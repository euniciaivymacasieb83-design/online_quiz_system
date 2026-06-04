<!-- Navigation Bar -->
<nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2 hover:opacity-90 transition">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                    <span class="text-2xl font-bold">QuizMaster</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md hover:bg-blue-700 focus:outline-none transition" id="mobile-menu-btn">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
       
        
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
<?php /**PATH C:\Users\User\Herd\online_quiz_system\resources\views/components/navbar.blade.php ENDPATH**/ ?>