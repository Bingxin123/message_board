<template>
  <div>
    <button @click="fetchHello">前後端分離</button>
  </div>
</template>

<script>
export default {
  methods: {
    fetchHello() {
      // 使用 Axios 或其他 HTTP 庫發送 GET 請求到 Laravel API
      fetch('http://localhost:8000/api/bookcreate')
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          console.log(response); 
        })
        .catch((error) => {
          console.log('error');
          console.error(error);
        });
    }
  }
};
</script>
