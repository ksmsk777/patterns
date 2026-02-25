<div class="tabs">
  <button class="tab-button active" data-tab="tab1">Вкладка 1</button>
  <button class="tab-button" data-tab="tab2">Вкладка 2</button>
  <button class="tab-button" data-tab="tab3">Вкладка 3</button>
</div>

<div class="tab-content">
  <div class="tab-pane active" id="tab1" data-src="/content/tab1.html">Загрузка...</div>
  <div class="tab-pane" id="tab2" data-src="/content/tab2.html">
  
  
  
    <div class="row" style="text-align:center; background-color:#f2f2f2; border-radius:3px; 
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
  <div class="tab-pane" id="tab3" data-src="/content/tab3.html">Загрузка...</div>
</div>



 <script>
document.addEventListener('DOMContentLoaded', () => {
  const tabButtons = document.querySelectorAll('.tab-button');
  const panes = document.querySelectorAll('.tab-pane');

  // Функция загрузки контента для конкретной панели
  function loadContent(pane) {
    const src = pane.dataset.src;
    if (!src) return;                     // нет источника
    if (pane.classList.contains('loaded')) return; // уже загружено

    // Опционально: показываем индикатор загрузки
    pane.innerHTML = 'Загрузка...';

    fetch(src)
      .then(response => {
        if (!response.ok) throw new Error('Ошибка загрузки');
        return response.text();
      })
      .then(html => {
        pane.innerHTML = html;
        pane.classList.add('loaded');      // помечаем как загруженное
      })
      .catch(error => {
        pane.innerHTML = 'Не удалось загрузить содержимое.';
        console.error(error);
      });
  }

  // Обработка кликов по вкладкам
  tabButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Снимаем активный класс со всех кнопок и панелей
      tabButtons.forEach(btn => btn.classList.remove('active'));
      panes.forEach(pane => pane.classList.remove('active'));

      // Активируем текущую кнопку
      button.classList.add('active');

      // Активируем связанную панель
      const tabId = button.getAttribute('data-tab');
      const activePane = document.getElementById(tabId);
      activePane.classList.add('active');

      // Загружаем контент для этой панели (если нужно)
      loadContent(activePane);
    });
  });

  // Загружаем контент для изначально активной вкладки
  const initialActivePane = document.querySelector('.tab-pane.active');
  if (initialActivePane) loadContent(initialActivePane);
});
</script>
  
  
  
  
  
<style>
.tab-button {
  padding: 10px 20px;
  background: #f0f0f0;
  border: 1px solid #ccc;
  cursor: pointer;
}
.tab-button.active {
  background: #fff;
  border-bottom-color: transparent;
}
.tab-content {
  border: 1px solid #ccc;
  padding: 20px;
  margin-top: -1px;
}
.tab-pane {
  display: none;
}
.tab-pane.active {
  display: block;
}
</style>






