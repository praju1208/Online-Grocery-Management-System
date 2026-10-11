function toggleFav(id, el){
  fetch('../app/controllers/FavouriteController.php?id=' + id)
    .then(() => {
      el.classList.toggle('active');
    });
}
