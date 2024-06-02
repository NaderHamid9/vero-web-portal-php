
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