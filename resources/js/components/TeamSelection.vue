<template>
    <div class="bg-gray-100 min-h-screen py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Rugby Teams</h1>
                <button @click="showCreateTeamModal = true"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                    Create Team
                </button>
            </div>

            <!-- Teams List -->
            <div v-if="loading" class="text-center py-10">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
                <p class="mt-3 text-gray-600">Loading teams...</p>
            </div>

            <div v-else-if="teams.length === 0" class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-600">No teams available. Create your first team to get started!</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="team in teams" :key="team.id"
                    class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h2 class="text-xl font-semibold text-gray-800">{{ team.name }}</h2>
                            <div class="flex space-x-2">
                                <button @click="editTeam(team)" class="text-indigo-600 hover:text-indigo-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button @click="confirmDeleteTeam(team)" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 text-gray-600">
                            <p v-if="team.location"><span class="font-medium">Location:</span> {{ team.location }}</p>
                            <p v-if="team.coach_name"><span class="font-medium">Coach:</span> {{ team.coach_name }}</p>
                            <p class="mt-2">{{ team.description || 'No description available.' }}</p>
                        </div>

                        <div class="mt-4">
                            <h3 class="font-medium text-gray-800 mb-2">Players ({{ team.players?.length || 0 }})</h3>
                            <div v-if="team.players && team.players.length > 0" class="space-y-2">
                                <div v-for="player in team.players" :key="player.id"
                                    class="flex justify-between items-center bg-gray-50 rounded p-2">
                                    <span>{{ player.name }} - {{ player.position }}</span>
                                    <button @click="removePlayerFromTeam(team, player)"
                                        class="text-red-600 hover:text-red-800 text-sm">
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div v-else class="text-gray-500 text-sm">
                                No players in this team.
                            </div>
                            <button @click="openAddPlayerModal(team)"
                                class="mt-3 w-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800 py-1 px-3 rounded text-sm">
                                Add Player
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create/Edit Team Modal -->
            <div v-if="showCreateTeamModal || showEditTeamModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <h2 class="text-2xl font-bold mb-4">
                        {{ showEditTeamModal ? 'Edit Team' : 'Create New Team' }}
                    </h2>

                    <form @submit.prevent="showEditTeamModal ? updateTeam() : createTeam()">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Team Name *</label>
                                <input type="text" v-model="teamForm.name" required
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" v-model="teamForm.location"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Coach Name</label>
                                <input type="text" v-model="teamForm.coach_name"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Founded Year</label>
                                <input type="number" v-model.number="teamForm.founded_year" min="1800"
                                    :max="new Date().getFullYear()"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Team Color</label>
                                <input type="text" v-model="teamForm.team_color" placeholder="e.g., Red and Blue"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea v-model="teamForm.description" rows="3"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="closeTeamModal"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                {{ showEditTeamModal ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Player to Team Modal -->
            <div v-if="isAddPlayerModalVisible"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <h2 class="text-2xl font-bold mb-4">Add Player to {{ selectedTeam?.name }}</h2>

                    <div v-if="loading" class="text-center py-6">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
                        <p class="mt-2 text-gray-600">Loading available players...</p>
                    </div>

                    <div v-else-if="availablePlayers.length === 0" class="py-6 text-center">
                        <p class="text-gray-600">No available players. Please create some players first.</p>
                    </div>

                    <div v-else class="max-h-64 overflow-y-auto">
                        <div v-for="player in availablePlayers" :key="player.id"
                            class="border-b border-gray-200 last:border-b-0 py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ player.name }}</p>
                                <p class="text-sm text-gray-600">{{ player.position }}</p>
                            </div>
                            <button @click="addPlayerToTeam(player.id)"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-md text-sm">
                                Add
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button @click="isAddPlayerModalVisible = false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Close
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div v-if="showDeleteModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <h2 class="text-2xl font-bold mb-4 text-red-600">Delete Team</h2>
                    <p class="mb-6">Are you sure you want to delete team "{{ teamToDelete?.name }}"? This action cannot
                        be undone, and all players will be removed from this team.</p>

                    <div class="flex justify-end space-x-3">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button @click="deleteTeam" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TeamsPage',
    data() {
        return {
            teams: [],
            availablePlayers: [],
            loading: true,
            errorMessage: null,
            successMessage: null,
            showCreateTeamModal: false,
            showEditTeamModal: false,
            isAddPlayerModalVisible: false,
            showDeleteModal: false,
            selectedTeam: null,
            teamToDelete: null,
            teamForm: {
                name: '',
                location: '',
                description: '',
                coach_name: '',
                founded_year: null,
                team_color: '',
            },
        };
    },
    created() {
        this.fetchTeams();
    },
    methods: {
        async fetchTeams() {
            this.loading = true;
            try {
                const response = await axios.get('/api/teams');
                this.teams = response.data;
            } catch (error) {
                this.errorMessage = 'Failed to load teams. Please try again.';
            } finally {
                this.loading = false;
            }
        },

        resetTeamForm() {
            this.teamForm = {
                name: '',
                location: '',
                description: '',
                coach_name: '',
                founded_year: null,
                team_color: '',
            };
        },

        async createTeam() {
            try {
                const response = await axios.post('/api/teams', this.teamForm);
                this.teams.push(response.data);
                this.closeTeamModal();
                await this.fetchTeams();
                this.successMessage = 'Team created successfully!';
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Failed to create team.';
            }
        },

        editTeam(team) {
            this.teamForm = { ...team };
            this.showEditTeamModal = true;
        },

        async updateTeam() {
            try {
                const response = await axios.put(`/api/teams/${this.teamForm.id}`, this.teamForm);
                const index = this.teams.findIndex(t => t.id === this.teamForm.id);
                if (index !== -1) {
                    this.teams[index] = response.data;
                }
                this.closeTeamModal();
                await this.fetchTeams();
                this.successMessage = 'Team updated successfully!';
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Failed to update team.';
            }
        },

        confirmDeleteTeam(team) {
            this.teamToDelete = team;
            this.showDeleteModal = true;
        },

        async deleteTeam() {
            if (!this.teamToDelete) return;

            try {
                await axios.delete(`/api/teams/${this.teamToDelete.id}`);
                this.teams = this.teams.filter(t => t.id !== this.teamToDelete.id);
                this.showDeleteModal = false;
                this.teamToDelete = null;
                this.successMessage = 'Team deleted successfully!';
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Failed to delete team.';
            }
        },

        closeTeamModal() {
            this.showCreateTeamModal = false;
            this.showEditTeamModal = false;
            this.resetTeamForm();
        },

        async openAddPlayerModal(team) {
            this.selectedTeam = team;
            this.isAddPlayerModalVisible = true;
            this.loading = true;

            try {
                const response = await axios.get('/api/players');
                this.availablePlayers = response.data.filter(player =>
                    player.team_id === null
                );
            } catch (error) {
                this.errorMessage = 'Failed to load available players.';
            } finally {
                this.loading = false;
            }
        },

        async addPlayerToTeam(playerId) {
            if (!this.selectedTeam) return;

            try {
                await axios.post(`/api/teams/${this.selectedTeam.id}/add-player`, {
                    player_id: playerId
                });
                await this.fetchTeams();
                this.isAddPlayerModalVisible = false;
                this.successMessage = 'Player added successfully!';
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Failed to add player.';
            }
        },

        async removePlayerFromTeam(team, player) {
            try {
                await axios.post(`/api/teams/${team.id}/remove-player`, {
                    player_id: player.id
                });
                await this.fetchTeams();
                this.successMessage = 'Player removed successfully!';
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Failed to remove player.';
            }
        }
    }
};
</script>