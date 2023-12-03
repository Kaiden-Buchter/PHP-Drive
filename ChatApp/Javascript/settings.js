const form = document.querySelector('.users form'),
saveBtn = form.querySelector('.button input'),
errorText = form.querySelector('.error-txt');

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submitting
}

saveBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest(); //creating XML object
    xhr.open("POST", "php/settings.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data == "success"){
                    location.href = "users.php";
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    let formData = new FormData(form); //creating new formData object
    xhr.send(formData); //sending form data to php
}