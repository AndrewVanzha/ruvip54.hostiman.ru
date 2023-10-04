var editButton = document.querySelector('.edit-button');
var saveButton = document.querySelector('.save-button');
var refuseButton = document.querySelector('.refuse-button');
var initButton = document.querySelector('.initial-button');
var clearButton = document.querySelector('.clear-button');
var contFlag = false;

window.addEventListener('DOMContentLoaded', function () {
  saveButton.disabled = true;
  saveButton.style.opacity = ".33";

  refuseButton.disabled = true;
  refuseButton.style.opacity = ".33";

  var newVar = String(localStorage.getItem('contFlag')); // признак предыдущего пользования
  //console.log(newVar);
  if (newVar == 'w') {
    //console.log('11'); // беру из Storage
    document.querySelector('.main-block').innerHTML = localStorage.getItem('newContent');
  } else {
    //console.log('22'); // превоначальный ввод
    localStorage.setItem('initContent', document.querySelector('.main-block').innerHTML);
  }
});

editButton.addEventListener('click', function (ev) { // редакция
  editButton.disabled = true;
  editButton.style.opacity = ".33";

  saveButton.disabled = false;
  saveButton.style.opacity = "1";

  refuseButton.disabled = false;
  refuseButton.style.opacity = "1";

  document.querySelector('.main-block').contentEditable = 'true';
  //console.log('edit');
  localStorage.setItem('oldContent', localStorage.getItem('newContent')); // перекачиваю в старый
});

saveButton.addEventListener('click', function (ev) { // сохранение
  saveButton.disabled = true;
  saveButton.style.opacity = ".33";

  editButton.disabled = false;
  editButton.style.opacity = "1";

  refuseButton.disabled = true;
  refuseButton.style.opacity = ".33";

  document.querySelector('.main-block').contentEditable = 'false';
  //console.log('save');
  localStorage.setItem('oldContent', localStorage.getItem('newContent')); // перекачиваю в старый
  localStorage.setItem('newContent', document.querySelector('.main-block').innerHTML); // беру с экрана
  localStorage.setItem('contFlag', 'w');
});

refuseButton.addEventListener('click', function (ev) { // отмена
  refuseButton.disabled = true;
  refuseButton.style.opacity = ".33";

  editButton.disabled = false;
  editButton.style.opacity = "1";

  saveButton.disabled = true;
  saveButton.style.opacity = ".33";

  document.querySelector('.main-block').contentEditable = 'false';
  //console.log('refuse');
  localStorage.setItem('newContent', localStorage.getItem('oldContent')); // перекачиваю в новый
  document.querySelector('.main-block').innerHTML = localStorage.getItem('oldContent'); // старый на экран
});

initButton.addEventListener('click', function (ev) { // загрузка Storage исходным
  if (localStorage.getItem('initContent') == null) {
    //console.log(localStorage.getItem('initContent'));
    editButton.disabled = true;
    editButton.style.opacity = ".33";
    localStorage.clear();
    alert('local storage пустая. Перезагрузи файл!');
  } else {
    localStorage.setItem('newContent', localStorage.getItem('initContent'));
    localStorage.setItem('oldContent', localStorage.getItem('initContent'));
    document.querySelector('.main-block').innerHTML = localStorage.getItem('oldContent');
  }
});

clearButton.addEventListener('click', function (ev) { // сброс Storage
  localStorage.clear();

  initButton.disabled = true;
  initButton.style.opacity = ".33";
  editButton.disabled = true;
  editButton.style.opacity = ".33";
  alert('local storage пустая. Перезагрузи файл!');
});