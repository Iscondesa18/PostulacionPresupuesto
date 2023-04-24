
$(document).ready(function(){
    $('#buscar_direccion').change(function(e){
        e.preventDefault();
        var sistema = getUrl();
        location.href = sistema = 'buscar_ficha.php?direccion='+$(this).val();



    })


});

function getUrl(){
    var loc= window.location;
    var pathName = loc.pathname.substring(0,loc.pathname.lastIndexOf('/')+1);
    return loc.href.substring(0,loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));

}



document.getElementById("clasif_pres").addEventListener("keyup", getClasif_pres)

function getClasif_pres() {
    let inputCP =document.getElementById("clasif_pres").value
    let lista =document.getElementById("lista")

    var url= "inc/getClasif_pres.php"
    let formData =new FormData()
    formData.append("clasif_pres", inputCP)

    fetch(url,{
        method:"POST",
        body: formData,
        mode: "cors"


    }).then(response => response.json())
    .then(data =>{
        lista.style.display = 'block'
        lista.innerHTML=data
    })
    .catch(err =>console.log(err))
    
}
