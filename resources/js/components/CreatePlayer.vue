<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-100 to-white">
        <div class="bg-white rounded-xl shadow-2xl p-10 w-full max-w-md">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Create Player</h2>
            <form @submit.prevent="createPlayer" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Player Name</label>
                    <input type="text" id="name" v-model="form.name" placeholder="Enter player name" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <input type="text" id="position" v-model="form.position" placeholder="Enter player position"
                        required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div>
                    <label for="team" class="block text-sm font-medium text-gray-700">Team</label>
                    <input type="text" id="team" v-model="form.team" placeholder="Enter team name" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Create Player
                </button>
                <div v-if="errorMessage" class="text-red-600 text-center mt-4">{{ errorMessage }}</div>
                <div v-if="successMessage" class="text-green-600 text-center mt-4">{{ successMessage }}</div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'CreatePlayer',
    data() {
        return {
            form: {
                name: '',
                position: '',
                team: '',
            },
            errorMessage: null,
            successMessage: null,
        };
    },
    methods: {
        async createPlayer() {
            try {
                this.errorMessage = null;
                this.successMessage = null;
                const response = await axios.post('/api/players', this.form);
                this.successMessage = 'Player created successfully!';
                this.form.name = '';
                this.form.position = '';
                this.form.team = '';
            } catch (error) {
                this.errorMessage =
                    error.response?.data?.message || 'An error occurred while creating the player.';
            }
        },
    },
};
</script>

<style scoped></style>