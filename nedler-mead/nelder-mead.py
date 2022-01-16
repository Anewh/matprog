from math import sqrt

def accuracy_reached(simplex, eps):
	f_values = tuple(map(lambda a: a[0], simplex))

	avg = sum(f_values) / len(f_values)
	sigma = sqrt(sum([(f - avg)**2 for i, f in enumerate(f_values)]) / len(f_values))

	print(f"{sigma=} < {eps=} - ", end="")
	print("истина" if sigma < eps else "ложь")
	return sigma < eps

def count_by_nelded_mead(x1, func, lamb, alpha, beta, gamma, eps):
	n = len(x1)

	delta1 = lamb * (sqrt(n + 1.) + n - 1.) / (n * sqrt(2.))
	delta2 = lamb * (sqrt(n + 1.)	  - 1.) / (n * sqrt(2.))

	# Шаг 1
	xi = [x1] + [[x1[j] for j in range(n)] for i in range(1, n+1)]

	for i in range(1, n + 1):
		for j in range(n):
			if j != i-1:
				xi[i][j] += delta1
			else:
				xi[i][j] += delta2

	simplex = [(func(x), tuple(x)) for x in xi]

	k = 1
	while k < 4096:
		print("Симплекс:")
		for i, (f, dot) in enumerate(simplex):
			print(f"f({dot[0]:.4f}; {dot[1]:.4f})\t= {f:.4f}")
		print()
		print(f"Итерация {k}:")
		# Шаг 2
		simplex = sorted(simplex, key=lambda a: a[0])
		fl, fg, fh = simplex[0][0], simplex[-2][0], simplex[-1][0]
		xl, xg, xh = simplex[0][1], simplex[-2][1], simplex[-1][1]

		print("Переобозначаем вершины: ")
		print(f'{xl=} {fl=}')
		print(f'{xg=} {fg=}')
		print(f'{xh=} {fh=}')
		print()

		# Шаг 3
		xc = [0. for i, _ in enumerate(xl)]
		for dot in (xl, xg):
			for i, c in enumerate(dot):
				xc[i] += c

		xc = tuple(map(lambda c: c / 2., xc))
		fc = func(xc)
		print(f'{xc=} {fc=}')

		# Шаг 4
		xr = tuple(map(lambda c: (1 + alpha) * c[0] - alpha*c[1], zip(xc, xh)))
		fr = func(xr)
		print(f'{xr=} {fr=}')

		# Шаг 5
		if fr < fl:
			print(f'{fr=} < {fl=} - истина')
			xe = tuple(map(lambda c: gamma*c[0] + (1-gamma)*c[1], zip(xr, xc)))
			fe = func(xe)

			if fe < fr:
				print(f'{fe=} < {fr=} - истина')
				print(f'Меняем точку xh на {xe=}; fh={fe}')
				simplex[-1] = (fe, xe)
			else:
				print(f'{fe=} >= {fr=} - истина')
				print(f'Меняем точку xh на {xr=}; fh={fr}')
				simplex[-1] = (fr, xr)

			if accuracy_reached(simplex, eps):
				return simplex[-1]

		elif fl <= fr <= fg:
			print(f'{fl=} <= {fr=} <= {fg=} - истина')
			print(f'Меняем точку xh на {xr=}; fh={fr}')
			simplex[-1] = (fr, xr)
			if accuracy_reached(simplex, eps):
				return (fl, xl)

		elif fg < fr:
			print(f'{fg=} < {fr=} - истина')
			# Шаг 6
			xs = None
			if fh < fr:
				print(f'{fh=} < {fr=} - истина')
				xs = tuple(map(lambda c: beta*c[0] + (1-beta)*c[1], zip(xh, xc)))
			else:
				print(f'{fh=} >= {fr=} - истина')
				xs = tuple(map(lambda c: beta*c[0] + (1-beta)*c[1], zip(xr, xc)))
			fs = func(xs)

			# Шаг 7
			if fs < min(fh, fr):
				print(f'{fs=} < min({fh=}, {fr=}) - истина')
				print(f'Меняем точку xh на {xs=}; fh={fs}')
				simplex[-1] = (fs, xs)
				if accuracy_reached(simplex, eps):
					return simplex[-1]

			elif fs >= fh:
				print(f'{fs=} >= {fh=} - истина')
				# Шаг 8

				xl = simplex[0][1]
				simplex2 = [simplex[0]] + [None for i in range(len(simplex)-1)]

				for i, pair in enumerate(simplex[1:], start=1):
					dot = tuple(map(lambda c: c[0] + 0.5 * (c[1] - c[0]), zip(xl, pair[1])))
					simplex2[i] = (func(dot), dot)

				simplex = simplex2

				if accuracy_reached(simplex, eps):
					return min(simplex, key=lambda a: a[0])
		k += 1
	else:
		return (None, None)

def func(p):
	return (p[0] - 1)**2 + 100 * (p[0] - p[1])**2

value, point = count_by_nelded_mead((-4., 6.), func, 
	lamb=2., alpha=2., beta=.5, gamma=2., eps=0.01)

if value is not None:
	print()
	print(f"Точка минимума: {point}")
	print(f"Значение функции: {value}")
else:
	print("Найти минимум не удалось")