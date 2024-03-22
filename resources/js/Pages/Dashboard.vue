<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

axios.defaults.withCredentials = true;

const items = ref([]);
const showModal = ref(false);
const selectedItem = ref({});
const loading = ref(false);
const voteSuccess = ref(false);
const votedItem = ref({});
const errorMessage = ref('');

const openModal = (item) => {
    errorMessage.value = '';  // Clear any existing error message
    selectedItem.value = item;
    showModal.value = true;
};
const castVote = async () => {
    loading.value = true;

    try {
        await axios.post('/api/vote', {
            item_id: selectedItem.value.id,
        });

        voteSuccess.value = true;
        votedItem.value = selectedItem.value.name;

    } catch (error) {
        if (error.response && error.response.status === 403) {
            errorMessage.value = error.response.data.message;  // Set the error message from the backend
            voteSuccess.value = false;  // Ensure success message is not shown
        } else {
            console.error('Error:', error.response ? error.response.data : 'An error occurred');
        }
    } finally {
        loading.value = false;
        showModal.value = false;
    }
};

onMounted(async () => {
    try {
        const response = await axios.get('/api/items');
        items.value = response.data;
        voteSuccess.value = response.headers['x-user-has-voted'] === 'true';
        votedItem.value = response.headers['x-user-voted-for']

    } catch (error) {
        console.error('Error fetching items:', error);
    }
});

</script>

<template>
    <Head title="Voting Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Voting Dashboard</h2>
        </template>

        <div class="py-12">
            <h1 class="text-4xl text-center font-semibold mb-8">Vote for your favorite Social Media platform</h1>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 max-sm:m-4">
                <!-- Error Message -->
                <div v-if="errorMessage" class="text-center p-4 mt-4 bg-red-200 text-red-800 rounded">
                    <p>{{ errorMessage }}</p>
                </div>

                <!-- Success Message -->
                <div v-else-if="voteSuccess" class="text-center p-4 mt-4 bg-green-200 text-green-800 rounded">
                    <p>Your vote for "{{ votedItem }}" has been successfully saved!</p>
                </div>

                <!-- Voting Options -->
                <div v-else class="grid grid-cols-2 gap-4">
                    <div v-for="item in items" :key="item.id" @click="openModal(item)" class="vote-box-style">
                        <i :class="`text-4xl ${item.icon}`" aria-hidden="true"></i>
                        <p class="text-center mt-4">{{ item.name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <i :class="`text-2xl ${selectedItem.icon}`"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Your Vote</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">Are you sure you want to vote for "{{ selectedItem.name }}"?</p>
                    </div>
                    <div class="items-center px-4 py-3 flex flex-row justify-center">
                        <button id="yes-btn" @click="castVote" class="yes-button flex justify-center items-center">
                            <span v-if="loading" class="spinner-border animate-spin inline-block w-4 h-4 border-4 rounded-full" role="status"></span>
                            <span v-else>Yes</span>
                        </button>
                        <button id="no-btn" @click="showModal = false" class="no-button">
                            No
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

