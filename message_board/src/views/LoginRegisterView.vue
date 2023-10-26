<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="form-container">
            <h2>登錄</h2>
            <label for="email">Email 地址:</label>
            <input type="email" class="form-control" placeholder="Enter email" v-model="loginEmail"/>
            <label for="password">密碼:</label>
            <input type="password" class="form-control" placeholder="Password" v-model="loginPassword"/>
            <br/>
            <button class="btn btn-primary" @click="login">登錄</button>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-container">
            <h2>註冊</h2>
            <label for="name">使用者名稱:</label>
            <input type="text" class="form-control" placeholder="Enter username" v-model="registerName"/>
            <label for="email">Email 地址:</label>
            <input type="email" class="form-control" placeholder="Enter email" v-model="registerEmail"/>
            <label for="password">密碼:</label>
            <input type="password" class="form-control" placeholder="Password" v-model="registerPassword"/>
            <br/>
            <button class="btn btn-primary" @click="register">註冊</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    data() {
      return {
        loginEmail: "",
        loginPassword: "",
        registerName: "",
        registerEmail: "",
        registerPassword: "",
      };
    },
    methods: {
      login() {
        const formData = new FormData();
        formData.append("email", this.loginEmail);
        formData.append("password", this.loginPassword);
        fetch("http://localhost:8000/api/auth/Login", {
          method: "POST",
          body: formData,
        })
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Login request failed");
          }
        })
        .then((response) => {
          localStorage.setItem("token", response.access_token);
          console.log(response);
          // 登錄成功後導航到 My_MessageView
          this.$router.push({ name: "home" });
          alert("User successfully logged in");
        })
        .catch((error) => {
          console.error(error);
        });
    },
    register() {
        const formData = new FormData();
        formData.append("name", this.registerName);
        formData.append("email", this.registerEmail);
        formData.append("password", this.registerPassword);
        formData.append("password_confirmation", this.registerPassword);
  
        fetch("http://localhost:8000/api/auth/Register", {
          method: "POST",
          body: formData,
        })
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Registration request failed");
          }
        })
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
<style>
body {
  background-color: #f5f5f5; /* 淺灰色背景 */
}
.container {
  margin-top: 50px;
}
.form-container {
  background-color: #fff; /* 白色表單背景 */
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}
</style>
