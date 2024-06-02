       $('#default-search').on('input', function() {
            const query = $(this).val();
            searchTasks(query);
                                });
        
        function searchTasks(query) {
            query = query.toLowerCase().trim(); // Convert query to lowercase and trim whitespace
            const filteredTasks = allTasks.filter(item =>
                item.task.toLowerCase().includes(query) ||
                item.title.toLowerCase().includes(query) ||
                item.description.toLowerCase().includes(query) ||
                item.colorCode.toLowerCase().includes(query)
            );
            updateTable(filteredTasks);
        }