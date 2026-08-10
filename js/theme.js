const themeButton = document.getElementById("themeButton");
themeButton.addEventListener("click",function (){
    document.body.classList.toggle("dark");
    console.log("Hello world!"); 
if (document.body.classList.contains("dark")) {

    themeButton.textContent = "حالت روشن";
    
} else {

    themeButton.textContent = "حالت تیره";
    
}

});