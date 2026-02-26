
// Круглая кнока плэй


<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>

<div class="tabs wow fadeInUp data-wow-duration=6s" >
  <button class="tab-button active" data-tab="tab1">Видео процесса работы</button>
  <button class="tab-button" data-tab="tab2">Видео ютюб</button>
   
</div>

<div class="tab-content">
  <div class="tab-pane active" id="tab1">
<div class="row " style="text-align:center;  border-radius:3px; 
border: 0px solid #ccc; padding:16px;">
 <div class="video-container">
<div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp " style="margin-bottom: 30px; margin-top:25px">
<video style="border-radius: 5px;" class="video-js" controls preload="auto" poster="/videos/tonirovka/22.jpg" data-setup='{ "fluid": true }'>
  <source src="/videos/tonirovka/tonir1.mp4" type="video/mp4">
</div>

<div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" style="margin-bottom: 10px;">
<video style="border-radius: 5px;" class="video-js" controls preload="auto" poster="/videos/tonirovka/444.jpg" data-setup='{ "fluid": true }'>
<source src="/videos/tonirovka/tonir1.mp4" type="video/mp4">
</video>
</div>
</div>
</div>

  </div>
  <div class="tab-pane" id="tab2">  
  <div class="row" style="text-align:center;  border-radius:3px; 
border: 0px solid 
#ccc; padding:16px;"><div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" 
style="visibility: visible; animation-
name:fadeInUp;">
<iframe style="border-radius: 8px; box-shadow: 2px 3px 6px #aaa;" width="100%" 
height="280px" 
	src="https://www.youtube.com/embed/k5WsnW3QNrk"
frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-
in-picture" 
allowfullscreen></iframe>
</div>
<div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" style="visibility: visible; animation-
name: fadeInUp;">
<iframe style="border-radius: 8px; box-shadow: 2px 3px 6px #aaa;" width="100%" 
height="280px" 
	src="https://www.youtube.com/embed/Y8Q6A6UmtOo"
frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-
in-picture" 
allowfullscreen></iframe>
</div>
</div>
  
  
  
  </div>
   
</div>
<script>
// Находим все кнопки вкладок
const tabButtons = document.querySelectorAll('.tab-button');

// Добавляем обработчик события на каждую кнопку
tabButtons.forEach(button => {
  button.addEventListener('click', () => {
    // Убираем класс active у всех кнопок и всех панелей
    tabButtons.forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

    // Добавляем класс active текущей кнопке
    button.classList.add('active');

    // Получаем идентификатор панели из атрибута data-tab
    const tabId = button.getAttribute('data-tab');
    // Показываем соответствующую панель
    document.getElementById(tabId).classList.add('active');
  });
});
</script>
<style>
.tab-button {
  padding: 5px 5px;
  background: #ccc;
  color:#141414;
  border: 0px solid #ccc;
  cursor: pointer;
  border-top-left-radius: 5px; 
  border-top-right-radius: 5px;
}
.tab-button.active {
  background: #fff;
  background: 
  color: #141414;
  border-bottom-color: transparent;
}
.tab-content {
  /*border: 1px solid #d31c30;
  border-radius: 5px;*/
  padding: 1px;   
  margin-top: -1px;
}
.tab-pane {
  display: none;
}
.tab-pane.active {
  display: block;
}

.video-container {
      width: 100%;
      max-width: 100%;
      margin: 0 auto;
    }

.video-js {
  color:red;
}

.video-js .vjs-big-play-button {
    font-size: 4em;
    width: 2em;
    height: 2em;
    line-height: 2em;
    margin-left: -1.1em;
    background-color: rgb(0 0 0 / 70%);
    border-radius: 100px;
 
}

.video-js:hover .vjs-big-play-button, .video-js .vjs-big-play-button:focus {
    border-color: #fff;
    background-color: rgb(112 112 112 / 50%);
    transition: all 0s;
}


</style>





