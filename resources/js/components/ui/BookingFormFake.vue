<template>
  <div class="hidden">
    <form @submit.prevent="">
      <input placeholder="Как к вам обращаться" name="client_fio" id="client_fio">
      <input placeholder="+7 (___) ___ __ __" name="client_phone" id="client_phone">
      <textarea placeholder="Напишите ваши пожелания" name="book_comment" id="book_comment"></textarea>
      <button type="submit">Забронировать</button>
    </form>
  </div>
</template>

<script>
export default {  
};
</script>
