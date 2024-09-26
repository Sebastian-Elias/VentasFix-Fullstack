<template>
    <div>
        <h2>Lista de Usuarios</h2>
        <ul>
            <li v-for="user in users" :key="user.id">
                {{ user.nombre }} {{ user.apellido }} - {{ user.email }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            users: [],
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        fetchUsers() {
            axios.get('/api/usuarios')
                .then(response => {
                    this.users = response.data; // Asumiendo que la respuesta contiene un array de usuarios
                })
                .catch(error => {
                    console.error('Error al obtener usuarios:', error);
                });
        }
    }
};
</script>

<style scoped>
/* Estilos opcionales para tu componente */
</style>
