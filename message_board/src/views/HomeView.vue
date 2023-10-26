<template>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">留言板</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="/"
              >首頁</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/my_message"
              >我的留言</router-link
            >
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false" @click="SearchUserProfile"
              >帳號資訊</a
            >
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" id="actionItem1"></a></li>
              <li><a class="dropdown-item" href="#" id="actionItem2"></a></li>
              <li><hr class="dropdown-divider" /></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>
        <div class="d-flex">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search"
            aria-label="Search" v-model="searchKeyword"
          />
          <button class="btn btn-outline-success" @click="searchAllComments">Search</button>
        </div>
      </div>
    </div>
  </nav>
  <br />

  <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel">新增留言</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">標題:</label>
              <input type="text" class="form-control" id="recipient-name" v-model="title"></div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">內容:</label>
              <textarea class="form-control" id="message-text" v-model="content"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
          <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">送出</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel2">Modal 2</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">確定要新增此留言嗎?</div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">再想一下</button>
          <button type="button" class="btn btn-primary" @click="AddMessage" data-bs-dismiss="modal">確定</button>
        </div>
      </div>
    </div>
  </div>
  <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">新增留言</a>
  <br/>
  <div class="row">
    <div class="col-sm-6 my-4 mb-sm-0" v-for="comment in All_Comment" :key="comment.id">
      <div class="card">
        <div class="card-header">{{ comment.title }}</div>
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <p>{{ comment.content }}</p>
            <footer class="blockquote-footer">
              {{ comment.author }} in
              <cite title="Source Title">{{ comment.created_at }}</cite>
            </footer>
          </blockquote>
        </div>
      </div>
    </div>
  </div>

  <!-- <div>
    <button @click="fetchHello">前後端分離</button>
    <button @click="checktoken">檢查Token</button>
    <button @click="updatetoken">刷新Token</button>
  </div> -->
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      newtoken: "",
      title: "",
      content: "",
      All_Comment: [],
      searchKeyword: "",
      actionItem: "",
      anotherActionItem: "",
    };
  },
  created() {
    // 在 created 鉤子中獲取後端資料
    this.fetchComments();
  },
  methods: {
    SearchUserProfile() {
    const authToken = localStorage.getItem("token"); 
    const headers = {
      Authorization: `Bearer ${authToken}`,
    };
    axios.get('http://localhost:8000/api/auth/User-Profile', { headers })
      .then((response) => {
        const userProfile = response.data;
        this.actionItem = document.getElementById("actionItem1");
        this.anotherActionItem = document.getElementById("actionItem2");
        this.actionItem.innerHTML = userProfile.name;
        this.anotherActionItem.innerHTML = userProfile.email;
        console.log('使用者資料：', userProfile);
      })
      .catch((error) => {
        console.error('獲取使用者資料時出錯：', error);
      });
    },
    searchAllComments() {
    const searchKeyword = this.searchKeyword; 
    const authToken = localStorage.getItem("token"); 
    const headers = {
      Authorization: `Bearer ${authToken}`,
    };

    axios.post('http://localhost:8000/api/auth/SearchAllComment', { searchKeyword }, { headers })
      .then((response) => {
        const userComments = response.data.search_results;
        console.log('使用者評論：', userComments);
      })
      .catch((error) => {
        console.error('搜尋使用者評論時出錯：', error);
      });
    },
    fetchComments() {
      const authToken = localStorage.getItem("token");
      const headers = {
        Authorization: `Bearer ${authToken}`,
      };
      axios
        .get("http://localhost:8000/api/auth/ReadAllComment", { headers })
        .then((response) => {
          // 列印後端返回的 JSON 資料
          this.All_Comment = response.data.all_comments;
          console.log(this.All_Comment);
        })
        .catch((error) => {
          console.error("獲取評論資料時發生錯誤：", error);
        });
    },
    AddMessage() {
      const axios = require("axios");
      const commentData = {
        title: this.title,
        content: this.content,
      };
      const authToken = localStorage.getItem("token");
      const headers = {
        Authorization: `Bearer ${authToken}`,
        "Content-Type": "application/json",
      };
      axios
        .post("http://localhost:8000/api/auth/CreateComment", commentData, {
          headers: headers,
        })
        .then((response) => {
          console.log("新增留言成功", response.data);
          this.fetchComments();
        })
        .catch((error) => {
          console.error("新增留言失敗：", error);
        });
    },
    checktoken() {
      this.newtoken = localStorage.getItem("token");
      console.log(this.newtoken);
    },
    updatetoken() {
      const token = localStorage.getItem("token");
      const requestOptions = {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };
      fetch("http://localhost:8000/api/auth/refresh", requestOptions)
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Token refresh request failed");
          }
        })
        .then((response) => {
          localStorage.setItem("token", response.access_token);
          console.log("NewToken:" + localStorage.getItem("token"));
          this.newtoken = localStorage.getItem("token");
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchHello() {
      // 使用 Axios 或其他 HTTP 庫發送 GET 請求到 Laravel API
      axios
        .get("http://localhost:8000/api/bookcreate")
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log("error");
          console.error(error);
        });
    },
  },
};
</script>
