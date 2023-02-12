<template>
    <div id="login">
        <form @submit.prevent="submit()">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <div class="form-group my-3">
                        <input type="text" required v-model="form.usuario" class="form-control" placeholder="Usuário">
                    </div>
                    <div class="form-group my-3">
                        <input type="password" required v-model="form.senha" class="form-control" placeholder="Senha">
                    </div>
                    <button class="btn btn-primary w-100 my-3">Acessar</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'Login',
        data: () => ({
            form: {
                usuario: 'kaua_009',
                senha: '07982480500'
            }
        }),
        methods: {
            ...mapActions(['Login']),
            async submit() {
                const result = await this.Login(this.form)
                
                if (result) {
                    this.$router.push('/')
                }
            }
        }
    }
</script>

<style>
    #login {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>