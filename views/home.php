<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        #tasks-container {
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        #tasks-container.hidden {
            opacity: 0;
        }

        body {
            background-color: rgb(17 24 39);
        }

        .title {
            margin-top: 150px;
        }
        .image-viewer-modal{
            margin: auto !important;
        }
    </style>
</head>

<body>
    <div class="spinner" id="loading-spinner"></div>

    <div class="container mx-auto index-container mb-5" id="tasks-container">
        <h1 class="title text-center text-5xl mt-20 font-semibold text-gray-800 capitalize sm:text-5xl dark:text-white form-title block me-auto mb-5">Tasks</h1>

        <button id="open-modal-btn" data-modal-target="default-modal" data-modal-toggle="default-modal"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Image Viewer
        </button>

        <div id="default-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-1/2 md:inset-0 h-[calc(100%-1rem)] max-h-full m-auto">
            <div class="relative p-4 w-full max-w-2xl max-h-full image-viewer-modal">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Image Viewer
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div id="view_area" class="p-4 md:p-5 space-y-4 text-white">
                        <p>Upload an image to view</p>
                    </div>
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <input id="image-upload"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            type="file" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <form class="max-w-md mx-auto mb-5 mt-5">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search Tasks" required />
            </div>
        </form>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="tasks-table">
                <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">#</th>
                        <th scope="col" class="px-6 py-3">Color</th>
                        <th scope="col" class="px-6 py-3">Task</th>
                        <th scope="col" class="px-6 py-3">Title</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                    </tr>
                </thead>
                <tbody id="tasks-table-body">
                    <?php foreach ($tasks as $index => $task): ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <?php echo $index + 1; ?>
                            </td>
                            <td class="px-6 py-4">
                                <button style="background-color: <?php echo htmlspecialchars($task['colorCode']); ?>"
                                    class="font-medium rounded-lg text-sm px-5 py-5 me-2 mb-2"></button>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo htmlspecialchars($task['task']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo htmlspecialchars($task['title']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="description-short">
                                    <?php
                                    $description = htmlspecialchars($task['description']);
                                    echo strlen($description) > 120 ? substr($description, 0, 120) . '...' : $description;
                                    ?>
                                </span>
                                <span class="description-full hidden">
                                    <?php echo $description; ?>
                                </span>
                                <?php if (strlen($description) > 120): ?>
                                    <button class="toggle-description text-blue-500">more</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let allTasks = [];

        $(document).ready(function () {
            function fetchTasks() {
                $('#tasks-container').addClass('hidden'); //Hide the table
                $('#loading-spinner').show(); // Show the spinner

                $.ajax({
                    url: '/tasks/update',
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('AJAX response data:', data);
                        if (data.status === 200 && Array.isArray(data.data)) {
                            allTasks = data.data;
                            updateTable(allTasks);
                        } else {
                            console.error('Failed to fetch tasks:', data);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Failed to fetch tasks. Status:', textStatus, 'Error:', errorThrown);
                    },
                    complete: function () {
                        $('#loading-spinner').hide(); //Hide the spinner
                        $('#tasks-container').removeClass('hidden'); //Show the table
                    }
                });
            }

            setTimeout(function () {
                fetchTasks(); // Initial fetch of tasks
                setInterval(fetchTasks, 15000); // Repeat fetch every 60 seconds
            }, 15000);
            
            $('#default-search').on('input', function() {
                 const query = $(this).val();
                 searchTasks(query);
             });
        });

        function updateTable(tasks) {
            let tbody = $('#tasks-table-body');
            tbody.empty();
            tasks.forEach((item, index) => {
                let truncatedDescription = item.description.length > 120 ? item.description.substring(0, 120) + '...' : item.description;
                let row = `
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">${index + 1}</td>
                        <td class="px-6 py-4">
                            <button style="background-color: ${item.colorCode}" class="font-medium rounded-lg text-sm px-5 py-5 me-2 mb-2"></button>
                        </td>
                        <td class="px-6 py-4">${item.task}</td>
                        <td class="px-6 py-4">${item.title}</td>
                        <td class="px-6 py-4">
                            <span class="description-short">${truncatedDescription}</span>
                            <span class="description-full hidden">${item.description}</span>
                            ${item.description.length > 120 ? '<button class="toggle-description text-blue-500">more</button>' : ''}
                        </td>
                    </tr>`;
                tbody.append(row);
            });
        }

        $('#default-search').on('input', function() {
    const query = $(this).val();
    searchTasks(query);
                        });

function searchTasks(query) {
    query = query.toLowerCase().trim(); // Convert query to lowercase and trim whitespace
    const filteredTasks = allTasks.filter(item =>
        item.task.toLowerCase().includes(query) ||
        item.title.toLowerCase().includes(query) ||
        item.description.toLowerCase().includes(query)
    );
    updateTable(filteredTasks);
}

        $(document).ready(function () {
            $(document).on('click', '.toggle-description', function () {
                const $this = $(this);
                const $short = $this.siblings('.description-short');
                const $full = $this.siblings('.description-full');
                if ($full.hasClass('hidden')) {
                    $full.removeClass('hidden');
                    $short.addClass('hidden');
                    $this.text('less');
                } else {
                    $full.addClass('hidden');
                    $short.removeClass('hidden');
                    $this.text('more');
                }
            });
        });

        $(document).ready(function () {
            $('#image-upload').on('change', function (event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#view_area').html(`<img src="${e.target.result}" alt="Uploaded Image" class="max-w-full h-auto rounded-lg">`);
                    }
                    reader.readAsDataURL(file);
                } else {
                    alert('Please upload a valid image file.');
                }
            });

            $('[data-modal-hide="default-modal"]').on('click', function () {
                $('#default-modal').addClass('hidden');
            });

            $('#open-modal-btn').on('click', function () {
                $('#default-modal').removeClass('hidden');
            });
        });
    </script>
</body>

</html>
