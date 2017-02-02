/**
 * Created by rgrisot on 02/02/17.
 */
function Uploader(idInput){
    if(typeof idInput === "undefined"){
        var obj = JSON.parse(window.localStorage.getItem('uploader'));
        this.idInput = obj.idInput;
    }else{
        this.idInput = idInput;
        window.localStorage.setItem('uploader', JSON.stringify(this));
    }
}