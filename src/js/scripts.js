// Функция для отправки AJAX запроса
function sendAjaxRequest(url, data, successCallback) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      successCallback(this.responseText);
    }
  };
  xhr.send(data);
}

// Обработчики кликов на кнопки рейтинга
const likeButtons = document.querySelectorAll('.like-btn');
likeButtons.forEach(button => {
  button.addEventListener('click', function() {
    const postId = this.dataset.postId;
    // Отправка AJAX запроса для обновления лайков
    sendAjaxRequest('src/includes/rating.php', `post_id=${postId}&action=like`, function(response) {
      // Обновляем количество лайков
      const likesSpan = document.querySelector(`#post-${postId} .likes`); // Получаем элемент .likes
      if (likesSpan) { // Проверяем, что элемент найден
        likesSpan.textContent = response;
      } else {
        console.error(`Элемент .likes для сообщения ${postId} не найден`);
      }
    });
  });
});

// Аналогично для dislikeButtons
const dislikeButtons = document.querySelectorAll('.dislike-btn');
dislikeButtons.forEach(button => {
  button.addEventListener('click', function() {
    const postId = this.dataset.postId;
    // Отправка AJAX запроса для обновления дизлайков
    sendAjaxRequest('src/includes/rating.php', `post_id=${postId}&action=dislike`, function(response) {
      // Обновляем количество ЛАЙКОВ (не дизлайков)
      const likesSpan = document.querySelector(`#post-${postId} .likes`); 
      if (likesSpan) { 
        likesSpan.textContent = response; 
      } else {
        console.error(`Элемент .likes для сообщения ${postId} не найден`);
      }
    });
  });
});