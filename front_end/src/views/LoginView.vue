<template>
  <div class="container">
    <form @submit.prevent="login">
      <h2 class="mb-3">Login</h2>
      <div class="input">
        <label for="email">Usuário</label>
        <input
          class="form-control"
          type="text"
          name="email"
          v-model="form.usuario"
        />
      </div>
      <div class="input">
        <label for="password">Senha</label>
        <input
          class="form-control"
          type="password"
          name="senha"
          v-model="form.senha"
        />
      </div>
      <div class="alternative-option mt-4">
        You don't have an account? <span @click="moveToRegister">Register</span>
      </div>
      <button type="submit" class="mt-4 btn-pers" id="login_button">
        Login
      </button>
      <transition name="fade">
        <p
          v-if="show"
          class="alert alert-warning alert-dismissible fade show mt-5"
          role="alert"
          id="alert_1"
        >
          {{ msg }}
        </p>
      </transition>
    </form>
  </div>
</template>



<script>
import { mapActions } from "vuex";

export default {
  name: "Login",
  data: () => {
    return {
      form: {
        usuario: "kaua_009",
        senha: "07982480500",
      },
      show: false,
      msg: "",
    };
  },
  mounted() {
    document.title = "Login";
  },
  methods: {
    ...mapActions(["Login", "setTokenAction"]),
    login() {
      var response = this.Login(this.form);

      response
        .then((res) => {
          this.setTokenAction(res.data.token);
          this.$router.push("/");
        })
        .catch((error) => {
          if (error.response.data.msg == "USUARIO NÃO ENCONTRADO") {
            this.showMessage("Usuário não encontrado!");
          } else if (error.response.data.msg == "SENHA INCORRETA") {
            this.showMessage("Senha incorreta!");
          }
        });
    },
    showMessage(msg) {
      this.show = true;
      this.msg = msg;
      setTimeout(() => {
        this.show = false;
      }, 4000);
    },
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>