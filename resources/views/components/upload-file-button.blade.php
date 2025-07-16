<div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    <!-- File Upload Button -->
    <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer"
        onclick="document.getElementById('fileInput').click();">
        <i class="fa-solid fa-file-arrow-up"></i> File Upload
    </div>

</div>

<script>
    // File input change handler
    document.getElementById('fileInput').addEventListener('change', function (event) {
        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        const blockedTypes = [
            'video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm',
            'audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/aac', 'audio/flac'
        ];

        const files = event.target.files;
        const selectedFiles = document.getElementById('selectedFiles');

        // Clear previous file list
        selectedFiles.innerHTML = '';

        if (files.length === 0) {
            return;
        }

        // Validate files
        for (const file of files) {
            if (blockedTypes.includes(file.type)) {
                alert(`"${file.name}" is not allowed. Video and audio files are not supported.`);
                event.target.value = '';
                return;
            }

            if (!allowedTypes.includes(file.type)) {
                alert(`"${file.name}" is not a supported file type. Please select images, PDF, Word, or Excel files only.`);
                event.target.value = '';
                return;
            }
        }

        // Display selected files
        for (const file of files) {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between py-1 px-2 bg-gray-50 dark:bg-gray-600 rounded mb-1';

            const fileIcon = getFileIcon(file.type);
            const fileSize = formatFileSize(file.size);

            fileItem.innerHTML = `
                <div class="flex items-center">
                    <i class="${fileIcon} mr-2"></i>
                    <span class="text-sm text-gray-700 dark:text-gray-300">${file.name}</span>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">${fileSize}</span>
            `;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgPreview = document.createElement('img');
                    imgPreview.src = e.target.result;
                    imgPreview.className = 'mt-2 w-16 h-16 object-cover rounded';
                    fileItem.appendChild(imgPreview);
                };
                reader.readAsDataURL(file);
            }

            selectedFiles.appendChild(fileItem);
        }

        // Open modal after files are processed
        openModal();
    });

    // Form submission handler
    document.getElementById('fileUploadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        const files = document.getElementById('fileInput').files;

        if (files.length === 0) {
            alert('Please select at least one file.');
            return;
        }

        // Add files to FormData
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                        document.querySelector('input[name="_token"]')?.value;

        if (csrfToken) {
            formData.append('_token', csrfToken);
        }

        // Show loading state
        const submitButton = document.querySelector('button[type="submit"][form="fileUploadForm"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Uploading...';
        submitButton.disabled = true;

        // Use fetch instead of jQuery
        fetch('/files/create_file', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message immediately
                Swal.fire({
                    icon: 'success',
                    title: data.message || 'Files uploaded successfully!',
                    showConfirmButton: false,
                    timer: 2000, // Show for 2 seconds
                    customClass: {
                        width: '24em',
                        title: 'text-xl'
                    }
                });

                // Close modal after 1 second
                setTimeout(() => {
                    closeModal();
                }, 500);

                // Reload page after 3 seconds
                setTimeout(() => {
                    location.reload();
                }, 3000);
            } else {
                alert(data.message || 'Upload failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Upload failed. Please try again.');
        })
        .finally(() => {
            // Reset button state
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        });
    });

    // Helper functions remain the same
    function getFileIcon(fileType) {
        switch (fileType) {
            case 'image/jpeg':
            case 'image/png':
            case 'image/webp':
                return 'fa-solid fa-image text-2xl text-gray-500';
            case 'application/pdf':
                return 'fa-solid fa-file-pdf text-2xl text-gray-500';
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return 'fa-solid fa-file-word text-2xl text-blue-500';
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return 'fa-solid fa-file-excel text-2xl text-green-500';
            default:
                return 'fa-solid fa-file text-2xl text-gray-500';
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function openModal() {
        const modal = document.getElementById('create-file-upload');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        const modal = document.getElementById('create-file-upload');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');

        // Clear file input and selected files display
        document.getElementById('fileInput').value = '';
        document.getElementById('selectedFiles').innerHTML = '';
    }

    // Close modal when clicking outside or on close button
    document.getElementById('create-file-upload').addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal();
        }
    });

    // Close modal when clicking close button
    document.querySelectorAll('[data-modal-hide="create-file-upload"]').forEach(button => {
        button.addEventListener('click', function(e) {
            if (e.target !== document.querySelector('button[type="submit"][form="fileUploadForm"]')) {
                closeModal();
            }
        });
    });
</script>
