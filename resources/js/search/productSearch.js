let timeout;
export function searchBar(){
const search=document.getElementById('searchInput')


search.addEventListener('input',function(){

    clearTimeout(timeout);

    timeout=setTimeout(()=>{
        axios.get('/search-products',{
            params:{
                search:this.value
            }
        }).then(res=>{
            document.getElementById('productsGrid').innerHTML=res.data;
        });
    },300);

});
}