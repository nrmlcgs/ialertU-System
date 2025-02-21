window.common = {
    hideModal: (e) => {
        let el = document.querySelector(`#${e}`);
        let bg = document.querySelector('#divModalBackground');
        el.style.display = "none";
        bg.style.display = "none";
    },
    showModal: (e) => {
        let el = document.querySelector(`#${e}`);
        let bg = document.querySelector('#divModalBackground');
        if (el){
 bg.style.display = "block";
        el.style.display = "block";
        }
       
    }
}