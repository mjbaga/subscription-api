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
        </style>
    </head>
    <body>
        <main class="container mx-auto mt-10 mb-10 max-w-3xl">
            <div id="app">
                <section class="subscribers-list">
                    <div class="container">
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
                    <div class="py-2" v-for="(sub,idx) in subscribers" :key="idx">
                        <div class="container">
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
                    <div class="flex flex-wrap items-center gap-4 my-4">
                        <button class="btn" @click="getPreviousSubs()" :disabled="page === 1">
                            Previous
                        </button>
                        <div>
                            <span>Showing {{ page }} of {{ totalPages }}</span>
                        </div>
                        <button class="btn" @click="getNextSubs()" :disabled="page === totalPages">
                            Next
                        </button>
                    </div>
                </section>
            </div>
        </main>
        <script src="./index.js"></script>
    </body>
</html>