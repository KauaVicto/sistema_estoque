<template>
  <card-component title="Login" icon="lock">
    <router-link slot="button" to="/" class="button is-small">
      Dashboard
    </router-link>

    <form method="POST" @submit.prevent="submit">
      <b-field label="E-mail Address">
        <b-input v-model="form.usuario" name="usuario" type="text" required />
      </b-field>

      <b-field label="Password">
        <b-input
          v-model="form.senha"
          type="password"
          name="senha"
          required
        />
      </b-field>

      <b-field>
        <b-checkbox v-model="form.remember" type="is-black" class="is-thin">
          Continuar conectado
        </b-checkbox>
      </b-field>

      <hr />

      <b-field grouped>
        <div class="control">
          <b-button native-type="submit" type="is-black" :loading="isLoading">
            Login
          </b-button>
        </div>
        <div class="control">
          <router-link to="/" class="button is-outlined is-black">
            Dashboard
          </router-link>
        </div>
      </b-field>
    </form>
  </card-component>
</template>

<script>
import { defineComponent } from "vue";
import CardComponent from "@/components/CardComponent.vue";
import { mapActions } from "vuex";

export default defineComponent({
  name: "LoginView",
  components: { CardComponent },
  data() {
    return {
      isLoading: false,
      form: {
        usuario: "kaua_009",
        senha: "07982480500",
        remember: false
      },
    };
  },
  methods: {
    ...mapActions(["Login", "setTokenAction"]),
    submit() {
      this.isLoading = true;

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
  },
});
</script>
