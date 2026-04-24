

export function storeCategory() {
    var cat=document.getElementById('categories').value;
    console.log(cat);
    axios.post('/admin/category',{
        categories:cat
    })
     .then(res => {

        const newCat = res.data.data;

        // 👇 ADD NEW OPTION WITHOUT REFRESH
        const select = document.getElementById('category');

        const option = document.createElement('option');
        option.value = newCat.id;
        option.text = newCat.name;

        select.appendChild(option);

    });
    
}

export function storeMaterial(){
    var mat=document.getElementById('materials').value;
    axios.post('/admin/material',{
        materials:mat
    })
     .then(res =>{
        
        const newMat=res.data.data;
        const select=document.getElementById('material');
        const option=document.createElement('option');
        option.value=newMat.id;
        option.text=newMat.type;
        select.appendChild(option);
     })
       
}

export function storeProduct(){
    const form=document.getElementById('productForm');
    const formData=new FormData(form);
    axios.post('/admin',formData)
     .then(res =>{
        console.log(form);
        console.log(res.data);
        form.reset();
     })
}