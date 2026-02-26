<!-- Круглая кнопка play с заголовками видео -->

<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>

<div class="tabs wow fadeInUp" data-wow-duration="6s">
  <button class="tab-button active" data-tab="tab1">Видео</button>
  <button class="tab-button" data-tab="tab2">YouTube</button>
</div>

<div class="tab-content">
  <!-- Вкладка с локальными видео -->
  <div class="tab-pane active" id="tab1">
    <div class="row" style="text-align:center; border-radius:3px; border:0px solid #ccc; padding:16px;">
      <!-- Первое видео -->
      <div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" style="margin-top:25px;">
        <div id="Title1" class="video-my-title">Основные принципы тонировки стекол автомобиля от профессионального Тонировщика!</div>
        <video class="video-js" controls preload="auto" poster="/videos/tonirovka/22.jpg" data-setup='{ "fluid": true }'>
          <source src="/videos/tonirovka/tonir1.mp4" type="video/mp4">
        </video>
      </div>
      <!-- Второе видео -->
      <div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" style="margin-top:25px;">
        <div id="Title2" class="video-my-title">Как затонировать автомобиль своими руками? Обучающее видео</div>
        <video class="video-js" controls preload="auto" poster="/videos/tonirovka/221.jpg" data-setup='{ "fluid": true }'>
          <source src="/videos/tonirovka/2.mp4" type="video/mp4">
        </video>
      </div>
    </div> <!-- .row -->
  </div> <!-- #tab1 -->

  <!-- Вкладка с YouTube видео -->
  <div class="tab-pane" id="tab2">
    <div class="row" style="text-align:center; border-radius:3px; border:0px solid #ccc; padding:16px;">
      <div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" style="visibility:visible; animation-name:fadeInUp;">
        <iframe style="border-radius:8px; box-shadow:2px 3px 6px #aaa;" width="100%" height="280px"
          src="https://www.youtube.com/embed/k5WsnW3QNrk"
          frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>
      <div class="col-lg-6 col-sm-6 col-xs-12 wow fadeInUp" style="visibility:visible; animation-name:fadeInUp;">
        <iframe style="border-radius:8px; box-shadow:2px 3px 6px #aaa;" width="100%" height="280px"
          src="https://www.youtube.com/embed/Y8Q6A6UmtOo"
          frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>
    </div> <!-- .row -->
  </div> <!-- #tab2 -->
</div> <!-- .tab-content -->

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
  /* Общие стили для вкладок */
  .tab-button {
    padding: 5px 5px;
    background: #eee;
    color: #141414;
    border: 0 solid #ccc;
    cursor: pointer;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }

  .tab-button.active {
    background: #fff;
    color: #141414;
    border-bottom-color: transparent;
  }

  .tab-content {
    padding: 1px;
    margin-top: -1px;
  }

  .tab-pane {
    display: none;
  }

  .tab-pane.active {
    display: block;
  }

  /* Видеоплеер */
  .video-js {
    color: red;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
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

  .video-js:hover .vjs-big-play-button,
  .video-js .vjs-big-play-button:focus {
    border-color: #fff;
    background-color: rgb(112 112 112 / 50%);
    transition: all 0s;
  }

  /* Выравнивание видео по нижнему краю при разной длине заголовков */
  .tab-pane.active .row {
    display: flex;
    flex-wrap: wrap;
  }

  .tab-pane.active .row > [class*="col-"] {
    display: flex;
    flex-direction: column;
  }

  .tab-pane.active .row > [class*="col-"] video {
    margin-top: auto;
    width: 100%; /* чтобы видео занимало всю ширину колонки */
  }
/* Колонка – флекс-контейнер, заголовок и видео разделяем space-between */
.tab-pane.active .row > [class*="col-"] {
  display: flex;
  flex-direction: column;
  justify-content: space-between;  /* заголовок сверху, видео снизу */
}

/* Контейнер, который создаёт Video.js, должен занимать всю доступную ширину и при необходимости растягиваться */
.tab-pane.active .row > [class*="col-"] .video-js {
  width: 100% !important;   
  flex-grow: 1;            
  align-self: stretch;      
  position: relative;       
  height: auto;           
}

.tab-pane.active .row > [class*="col-"] .video-js .vjs-tech {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.video-my-title
{
    font-size: 1.2em;
    background: #000;
    color: #fff;
    padding: 6px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    }
</style>

