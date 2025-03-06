<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 class="text-2xl font-bold mb-4">Add Player to {{ team.name }}</h2>

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
                    <button @click="$emit('add-player', player.id)"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-md text-sm">
                        Add
                    </button>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button @click="$emit('close')"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: Boolean,
        team: Object,
        availablePlayers: Array,
        loading: Boolean
    }
};
</script>