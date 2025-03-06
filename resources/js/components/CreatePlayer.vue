<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-100 to-white">
        <div class="bg-white rounded-xl shadow-2xl p-10 w-full max-w-lg">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Create Player</h2>

            <div v-if="loading" class="text-center py-6">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
                <p class="mt-3 text-gray-600">Loading teams...</p>
            </div>

            <form v-else @submit.prevent="createPlayer" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Player Name</label>
                    <input type="text" v-model="form.name" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Position</label>
                    <select v-model="form.position" required @change="updateStatCaps"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option disabled value="">Select a position</option>
                        <option v-for="(stats, position) in positionCaps" :key="position" :value="position">
                            {{ position }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Team</label>
                    <select v-model="form.team_id"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">No Team (Player won't be eligible to play)</option>
                        <option v-for="team in teams" :key="team.id" :value="team.id">
                            {{ team.name }}
                        </option>
                    </select>
                    <p class="text-sm text-red-600 mt-1" v-if="!form.team_id">
                        Note: Players must be on a team to play in games.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Height (cm)</label>
                        <input type="number" v-model.number="form.height" placeholder="e.g., 180"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                        <input type="number" v-model.number="form.weight" placeholder="e.g., 75"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div v-for="stat in stats" :key="stat.key">
                        <label :for="stat.key" class="block text-sm font-medium text-gray-700 capitalize">
                            {{ stat.label }}
                        </label>
                        <input :id="stat.key" type="number" v-model.number="form[stat.key]" min="0"
                            :max="getStatCap(stat.key)" @input="validateStat(stat.key)"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        <p class="text-xs text-gray-500">Max: {{ getStatCap(stat.key) }}</p>
                    </div>
                </div>

                <div class="text-sm text-gray-600">
                    Total Stat Points: <span :class="{ 'text-red-600': isOverAllocated }">{{ totalStatPoints }}</span>
                    <span> / Allowed: {{ allowedTotal }}</span>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                    :disabled="isOverAllocated || !form.position">
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
                team_id: null, // Changed from 'team' to 'team_id' to match backend
                height: null,
                weight: null,
                speed: 50,
                strength: 50,
                agility: 50,
                stamina: 50,
                tackling: 50,
                kicking: 50,
                passing: 50,
            },
            teams: [], // Added to store available teams
            loading: true, // Added loading state
            errorMessage: null,
            successMessage: null,
            stats: [
                { key: 'speed', label: 'Speed' },
                { key: 'strength', label: 'Strength' },
                { key: 'agility', label: 'Agility' },
                { key: 'stamina', label: 'Stamina' },
                { key: 'tackling', label: 'Tackling' },
                { key: 'kicking', label: 'Kicking' },
                { key: 'passing', label: 'Passing' },
            ],
            positionCaps: {
                'fly-half': { total: 400, speed: 65, strength: 50, agility: 65, stamina: 60, tackling: 50, kicking: 60, passing: 50 },
                'scrumhalf': { total: 400, speed: 70, strength: 50, agility: 65, stamina: 55, tackling: 55, kicking: 40, passing: 65 },
                'prop': { total: 400, speed: 40, strength: 90, agility: 40, stamina: 70, tackling: 80, kicking: 20, passing: 60 },
                'lock': { total: 400, speed: 45, strength: 85, agility: 45, stamina: 75, tackling: 80, kicking: 20, passing: 50 },
                'third row': { total: 400, speed: 55, strength: 75, agility: 60, stamina: 70, tackling: 75, kicking: 30, passing: 35 },
                'number 8': { total: 400, speed: 50, strength: 80, agility: 55, stamina: 75, tackling: 80, kicking: 30, passing: 30 },
                'center': { total: 400, speed: 60, strength: 60, agility: 70, stamina: 65, tackling: 55, kicking: 40, passing: 50 },
                'wing': { total: 400, speed: 85, strength: 50, agility: 75, stamina: 60, tackling: 40, kicking: 30, passing: 40 },
                'fullback': { total: 400, speed: 75, strength: 55, agility: 65, stamina: 70, tackling: 50, kicking: 55, passing: 30 },
            }
        };
    },
    
    // Added created lifecycle hook to fetch teams when component loads
    created() {
        this.fetchTeams();
    },

    computed: {
        totalStatPoints() {
            return this.stats.reduce((sum, stat) => sum + (this.form[stat.key] || 0), 0);
        },
        allowedTotal() {
            return this.form.position ? this.positionCaps[this.form.position].total : 0;
        },
        isOverAllocated() {
            return this.totalStatPoints > this.allowedTotal;
        },
    },
    methods: {
        // Added method to fetch teams from the API
        async fetchTeams() {
            this.loading = true;
            try {
                const response = await axios.get('/api/teams');
                this.teams = response.data;
            } catch (error) {
                console.error('Error fetching teams:', error);
                this.errorMessage = 'Failed to load teams. Please try again.';
            } finally {
                this.loading = false;
            }
        },
        
        updateStatCaps() {
            // Don't reset all stats, just ensure they don't exceed caps
            if (this.form.position) {
                this.stats.forEach(stat => {
                    this.validateStat(stat.key);
                });
            }
        },
        
        getStatCap(statKey) {
            return this.form.position ? this.positionCaps[this.form.position][statKey] || 100 : 100;
        },
        
        validateStat(statKey) {
            const cap = this.getStatCap(statKey);
            if (this.form[statKey] > cap) {
                this.form[statKey] = cap;
            }
        },
        
        async createPlayer() {
            this.errorMessage = null;
            this.successMessage = null;

            if (this.isOverAllocated) {
                this.errorMessage = `Total stat points (${this.totalStatPoints}) exceed the allowed maximum of ${this.allowedTotal}.`;
                return;
            }

            try {
                // If a team is selected, get the team name for the 'team' field
                if (this.form.team_id) {
                    const selectedTeam = this.teams.find(team => team.id === this.form.team_id);
                    if (selectedTeam) {
                        this.form.team = selectedTeam.name;
                    }
                } else {
                    // Reset team name if no team selected
                    this.form.team = null;
                }
                
                const response = await axios.post('/api/players', this.form);
                this.successMessage = 'Player created successfully!';
                
                setTimeout(() => {
                    // Optionally redirect to players list or clear form
                    // this.$router.push('/players');
                    this.resetForm();
                }, 2000);
            } catch (error) {
                if (error.response && error.response.data && error.response.data.message) {
                    this.errorMessage = error.response.data.message;
                } else {
                    this.errorMessage = 'An error occurred while creating the player. Please try again.';
                }
                console.error('Error creating player:', error);
            }
        },
        
        resetForm() {
            this.form = {
                name: '',
                position: '',
                team_id: null,
                team: null,
                height: null,
                weight: null,
                speed: 50,
                strength: 50,
                agility: 50,
                stamina: 50,
                tackling: 50,
                kicking: 50,
                passing: 50,
            };
            this.successMessage = null;
            this.errorMessage = null;
        }
    }
};
</script>