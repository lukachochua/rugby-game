<template>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Players List</h1>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Position</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Team</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="player in players" :key="player.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ player.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ player.position }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ player.team }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="loading" class="mt-4 text-center text-gray-600">Loading players...</div>
            <div v-if="error" class="mt-4 text-center text-red-600">{{ error }}</div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ViewPlayers',
    data() {
        return {
            players: [],
            loading: false,
            error: null,
        };
    },
    methods: {
        async fetchPlayers() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get('/api/players');
                this.players = response.data;
            } catch (err) {
                this.error = err.response?.data?.message || 'Failed to load players.';
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchPlayers();
    },
};
</script>

<style scoped></style>