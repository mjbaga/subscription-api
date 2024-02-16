<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Subscribers API by Marvin Jayson Baga</title>
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
        <style type="text/tailwindcss">
            .btn {
                @apply bg-white rounded-md px-4 py-2 text-center font-medium text-slate-500 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50 h-10;
            }

            .btn:disabled {
                color: gray;
            }

            .btn:disabled:hover {
                background: white;
            }
        </style>
    </head>
    <body>
        <main class="@container mx-auto mt-10 mb-10 max-w-3xl">
            <div id="app">
                <section class="subscribers-list flex flex-col items-center">
                    <h1 class="text-center text-3xl pb-4">My List of Subscribers</h2>
                    <div class="list-container">
                        <div class="list-heading">
                            <div class="flex gap-4">
                                <div class="w-32">
                                    First Name
                                </div>
                                <div class="w-32">
                                    Last Name
                                </div>
                                <div class="w-32">
                                    Status
                                </div>
                            </div>
                        </div>
                        <div class="list-body">
                            <div class="py-2" v-for="(sub,idx) in subscribers" :key="idx">
                                <div class="flex gap-4">
                                    <div class="w-32">
                                        {{ sub.name }}
                                    </div>
                                    <div class="w-32">
                                        {{ sub.last_name }}
                                    </div>
                                    <div class="w-32">
                                        {{ sub.status }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-4 my-4">
                        <button class="btn" @click="getPreviousSubs" :disabled="page === 1">
                            Previous
                        </button>
                        <div>
                            <span>Showing {{ page }} of {{ totalPages }} pages</span>
                        </div>
                        <button class="btn" @click="getNextSubs" :disabled="page === totalPages">
                            Next
                        </button>
                    </div>
                </section>
                <section class="subscriber-form flex flex-col items-center">
                    <h2 class="text-center text-2xl pb-4">Create Subscriber</h2>
                    <p v-if="formMessage">{{ formMessage }}</p>
                    <form class="flex flex-col" @submit.prevent="submitForm">
                        <div class="flex gap-2 pb-2 flex-wrap items-center">
                            <label for="name" class="w-32">Name</label>
                            <input 
                                class="form-input w-64 rounded-md" 
                                type="text" 
                                name="name" 
                                v-model="data.name"
                                required  
                            />
                        </div>
                        <div class="flex gap-2 pb-2 flex-wrap items-center">
                            <label for="last_name" class="w-32">Last Name</label>
                            <input 
                                class="form-input w-64 rounded-md" 
                                type="text" 
                                name="last_name" 
                                v-model="data.lastName"
                                required
                            />
                        </div>
                        <div class="flex gap-2 pb-2 flex-wrap items-center">
                            <label for="name" class="w-32">Status</label>
                            <select 
                                name="status" 
                                class="px-4 py-3 rounded-md w-64" 
                                v-model="data.status"
                            >
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button class="btn mt-4 self-center">
                            Add new subscriber
                        </button>
                    </form>
                </section>
            </div>
        </main>
        <script src="./index.js"></script>
    </body>
</html>