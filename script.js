var mytimeout;
function showinfomsg(bgcolor,color,msg,icon){
  clearTimeout(mytimeout);
  let infomsg = document.getElementsByClassName('infomsg')[0]
  infomsg.style.backgroundColor = bgcolor;
  infomsg.style.color = color;
  infomsg.children[1].innerText= msg;
  infomsg.children[0].classList= icon;
  infomsg.classList.remove('active')
  setTimeout(() => {
    infomsg.classList.add('active')
  }, 0);
  mytimeout = setTimeout(() => {
    infomsg.classList.remove('active')
  }, 5000);
  
}
    function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    
    setTimeout(showTime, 1000);
    
}
showTime();
var modal = document.getElementsByClassName("modal-body")[0]

function popuphide(){
    modal.innerHTML = `<div class="row">
                <div class="form-floating mb-1 col-12">
                    <input type="text" class="form-control" id="name0" placeholder="name@example.com">
                    <label for="floatingInput">Song Name</label>
                  </div>
                  <div class="form-floating col-6">
                    <input type="text" class="form-control" id="singer0" placeholder="Password">
                    <label for="floatingPassword">Singer Name</label>
                  </div>
                  <div class="form-floating col-6">
                    <input type="text" class="form-control" id="album0" placeholder="name@example.com">
                    <label for="floatingInput">Album Name</label>
                  </div>
                  <div class="form-floating col-12 mt-1">
                    <textarea class="form-control" placeholder="Leave a comment here" id="lyrics0"></textarea>
                    <label for="floatingTextarea">lyrics</label>
                  </div>
            </div>`
    formscount = 1
    document.getElementById("counter").innerText = formscount;
}

var formscount = 1

function addorremoveform(num){
    formscount += num
    if(formscount < 1){formscount=1}
    modal.innerHTML=``
    for(let i = 0;i<formscount;i++){
        modal.innerHTML+=`<div class="row my-1">
                <div class="form-floating mb-1 col-12">
                    <input type="text" class="form-control" id="name${i}" placeholder="name@example.com">
                    <label for="floatingInput">Song Name</label>
                  </div>
                  <div class="form-floating col-6">
                    <input type="text" class="form-control" id="singer${i}" placeholder="Password">
                    <label for="floatingPassword">Singer Name</label>
                  </div>
                  <div class="form-floating col-6">
                    <input type="text" class="form-control" id="album${i}" placeholder="name@example.com">
                    <label for="floatingInput">Album Name</label>
                  </div>
                  <div class="form-floating col-12 mt-1">
                    <textarea class="form-control" placeholder="Leave a comment here" id="lyrics${i}"></textarea>
                    <label for="floatingTextarea">lyrics</label>
                  </div>
            </div>`
}
document.getElementById("counter").innerText = formscount;
}

async function addsongs(){
  let insertcount = 0;
    for(let i = 0;i<formscount;i++){
        
    let name = datacheck(document.getElementById('name'+i).value);
    let singer = datacheck(document.getElementById('singer'+i).value);
    let album = datacheck(document.getElementById('album'+i).value);
    let lyrics = datacheck(document.getElementById('lyrics'+i).value);
    if(name!='' && singer!='' && album!='' && lyrics!='' ){
      let data =[name,singer,album,lyrics];
      await fetch("script.php?action=add&data="+JSON.stringify(data))
      insertcount++;
    }else{
      var err=i+1;
    }
    }
    if(insertcount == formscount){
      showinfomsg('green','white','All Songs Added Successfully','fa-solid fa-triangle-exclamation')
    }else{
      showinfomsg('red','white','Song N°'+err+' Not Added Successfully','fa-solid fa-xmark')
    }
    document.querySelector('.btn-close').click();
    getsongs();
    getstatistics();
    

}

function datacheck(str){
  str = str.replace(/[^a-zA-Z0-9 ]/g, "");
  str = str.replace(/(<([^>]+)>)/gi, "");
  str = str.replaceAll("  ","");
  str = str.trim();
  return str;

}

getsongs()
var table;
async function getsongs(){
  if ($.fn.DataTable.isDataTable('#txmpl')){
    $('#txmpl').dataTable().fnDestroy();
 }
    let myObject = await fetch('script.php?action=get');
    let res = await myObject.json();
    let tbody = document.getElementById('tablebody')
    tbody.innerHTML=``;
    await res.forEach(row => {
        tbody.innerHTML+=`
        <tr>
                <th scope="row" contenteditable onblur='update(this,"song_name",${row.id})'>${row.song_name}</th>
                <td contenteditable onblur='update(this,"singer_name",${row.id})'>${row.singer_name}</td>
                <td contenteditable onblur='update(this,"album_name",${row.id})'>${row.album_name}</td>
                <td contenteditable onblur='update(this,"created_at",${row.id})'>${row.created_at}</td>
                <td ><button data-bs-toggle="modal" data-bs-target="#lyricsModal" class="btn btn-success text-nowrap" onclick="showlyrics('${row.lyrics}',${row.id})">See Lyrics</button><button onclick="deletesong(${row.id},this)" class="btn m-1 btn-danger">Delete</button></td>
        </tr>
        `;

    });
    
  $(document).ready(function() {
  table = $('#txmpl').DataTable({
    // responsive: true
  })
  .columns.adjust()
  .responsive.recalc();
});

}

async function deletesong(id,elem){
    await fetch("script.php?action=delete&id="+id)
    showinfomsg('green','white','Song deleted successfully','fa-regular fa-circle-check')
    getsongs()
}

function showlyrics(lyrics,id){
  document.getElementById('lyricscontent').innerText = lyrics;
  document.getElementById('lyricscontent').setAttribute('onblur','update(this,"lyrics",'+id+')');
}

function update(elem,where,id){
  let content = elem.innerText;
  fetch('script.php?action=update&where='+where+'&id='+id+'&content='+content)
}

async function getstatistics(){
  let myObject = await fetch('script.php?action=getstatistics');
    let res = await myObject.json();
    document.getElementById('usercount').innerText = res.usercount +' User'
    document.getElementById('singerscount').innerText = res.singerscount +' Singer'
    document.getElementById('albumscount').innerText = res.albumscount +' Album'
    document.getElementById('songscount').innerText = res.songscount +' Song'
}

getstatistics()

function fnav(elem){
  getstatistics();
  let snav = document.getElementsByClassName('snav');
  Array.from(snav).forEach(item=>{
    item.classList.remove('active');
  })
  let fnav = document.getElementsByClassName('fnav');
  Array.from(fnav).forEach(item=>{
    item.classList.add('active');
  })
  elem.classList.add('active');
  document.getElementById('statistics').classList.remove('d-none')
  document.getElementById('recipients').classList.add('d-none')
}

function snav(elem){
  getsongs();
  let snav = document.getElementsByClassName('snav');
  Array.from(snav).forEach(item=>{
    item.classList.add('active');
  })
  let fnav = document.getElementsByClassName('fnav');
  Array.from(fnav).forEach(item=>{
    item.classList.remove('active');
  })
  elem.classList.add('active');
  document.getElementById('statistics').classList.add('d-none')
  document.getElementById('recipients').classList.remove('d-none')
}
