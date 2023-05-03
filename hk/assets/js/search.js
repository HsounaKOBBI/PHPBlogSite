<script type="text/javascript">
function getXMLHttpRequest(){
    var xhr =null ;
try{
    xhr= new ActiveXObject("Microsoft.WMLHTTP");

}
catch(e){
    xhr= new XMLHttpRequest();
}
return xhr ;
}
function filtrer()
{
  var filtre, tableau,ligne,cellule,i,texte
  filtre= document.getElementById("maRecherche").value.toUpperCase();
  tableau= document.getElementById("tableau");
  ligne=tableau.getElementById("hh");
  for (i=0;i<ligne.length;i++){
    cellule=ligne[i].getElementsByTagName("h2");
    if (cellule){
        texte =cellule.innerText;
        if (texte.toUpperCase().indexOf(filtre)>-1){
           ligne[i].style.display="";
        }
        else{
           ligne[i].style.display ="none";
        }
    }
  }
}
</script>