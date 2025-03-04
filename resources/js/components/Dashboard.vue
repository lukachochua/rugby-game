<template>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto p-6">
            <h1 class="text-4xl font-bold text-gray-800 mb-8">Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Recent Activity</h2>
                    <p class="text-gray-600">No recent activity.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Stats</h2>
                    <p class="text-gray-600">Statistics will be shown here.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Notifications</h2>
                    <p class="text-gray-600">No new notifications.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dashboard',
};
</script>