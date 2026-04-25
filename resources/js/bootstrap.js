import axios from 'axios';
import Alpine from 'alpinejs';
import { storeCategory,storeMaterial, storeProduct } from './admin/admin';
import { searchBar } from './search/productSearch';
document.addEventListener('DOMContentLoaded', () => {
    searchBar();
});
window.axios = axios;
window.storeCategory = storeCategory;
window.storeMaterial = storeMaterial;
window.storeProduct = storeProduct;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Alpine=Alpine;


Alpine.start();