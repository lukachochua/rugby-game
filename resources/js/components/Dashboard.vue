<template>
    <div class="min-h-screen bg-gray-100">
        <div class="flex">
            <div class="w-64 bg-blue-800 text-white p-5">
                <!-- Sidebar -->
                <h2 class="text-lg font-bold">Dashboard</h2>
                <ul class="mt-5">
                    <li class="mb-3 hover:bg-blue-700 p-2 rounded">Overview</li>
                    <li class="mb-3 hover:bg-blue-700 p-2 rounded">Settings</li>
                    <li class="mb-3 hover:bg-blue-700 p-2 rounded">Log Out</li>
                </ul>
            </div>
            <div class="flex-1 p-8">
                <!-- Dashboard Content -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">Recent Activity</h3>
                        <!-- Content here -->
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">Stats</h3>
                        <!-- Content here -->
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">Notifications</h3>
                        <!-- Content here -->
                    </div>
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