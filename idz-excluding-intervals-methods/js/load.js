function readFile(){
    const file = document.getElementById('file_load').files[0];
    console.log(file);

    let reader = new FileReader();
    reader.readAsText(file);

    reader.onload = function() {
      console.log(reader.result);
      fill_inputs(reader.result);
    };
}

function fill_inputs(data){
    let index_next = data.indexOf('\n', 0);
    let func = '';
    for(i=0;i<index_next;i++){
        func += data[i]; 
    }   
    document.getElementById('func').value = func;

    let left_border = '';

    let index_start = index_next + 1;
    index_next = data.indexOf('\n', index_start);
    for(i=index_start;i<index_next;i++){
        left_border += data[i]; 
    }

    document.getElementById('left_bound').value = left_border;

    let right_border = '';

    index_start = index_next + 1;
    index_next = data.indexOf('\n', index_start);
    for(j=index_start;j<index_next;j++){
        right_border += data[j];
    }
    document.getElementById('right_bound').value = right_border;

    let eps = '';

    index_start = index_next + 1;
    index_next = data.indexOf('\n', index_start);
    for(j=index_start;j<index_next;j++){
        eps += data[j];
    }
    document.getElementById('eps').value = eps;
}