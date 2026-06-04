<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Logo Card -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Logo Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-8 px-6 text-center">
                <!-- SVG Logo -->
                <svg class="w-24 h-24 mx-auto mb-4" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <!-- Background Circle -->
                    <circle cx="100" cy="100" r="95" fill="white" opacity="0.95" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                    
                    <!-- Main Logo Group -->
                    <g transform="translate(100, 100)">
                        <!-- Book/Certificate Shape -->
                        <rect x="-35" y="-45" width="70" height="90" rx="6" fill="rgb(59, 130, 246)"/>
                        
                        <!-- Pages detail -->
                        <rect x="-33" y="-43" width="66" height="4" fill="white" opacity="0.3"/>
                        <rect x="-33" y="-35" width="66" height="2" fill="white" opacity="0.2"/>
                        <rect x="-33" y="-30" width="66" height="2" fill="white" opacity="0.2"/>
                        
                        <!-- Hat (Graduation Cap) -->
                        <g transform="translate(0, -50)">
                            <line x1="-40" y1="0" x2="40" y2="0" stroke="white" stroke-width="4" stroke-linecap="round"/>
                            <polygon points="0,-15 -8,0 8,0" fill="white"/>
                            <circle cx="0" cy="2" r="3" fill="white"/>
                        </g>
                        
                        <!-- Star Badge -->
                        <g transform="translate(25, -20)">
                            <polygon points="0,-12 3,-4 12,-4 5,2 8,10 0,5 -8,10 -5,2 -12,-4 -3,-4" fill="rgb(34, 197, 94)"/>
                        </g>
                        
                        <!-- Checkmark inside -->
                        <polyline points="-5,5 0,10 10,0" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>

                <!-- Logo Text -->
                <h1 class="text-4xl font-bold text-white">QuizMaster</h1>
                <p class="text-blue-100 mt-2">Create • Take • Master</p>
            </div>

            <!-- Registration Form -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Create Your Account</h2>

                <?php if($errors->any()): ?>
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                            <p class="font-semibold text-red-800">Please fix the following errors:</p>
                        </div>
                        <ul class="list-disc list-inside text-red-600 text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">

                <?php if($errors->any()): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>❌ <?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
                    <?php echo csrf_field(); ?>

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Full Name
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="<?php echo e(old('name')); ?>"
                            required 
                            autofocus
                            autocomplete="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="John Doe"
                        >
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="<?php echo e(old('email')); ?>"
                            required 
                            autocomplete="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="john@example.com"
                        >
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-check mr-2 text-blue-600"></i>I am a...
                        </label>
                        <select 
                            id="role" 
                            name="role" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >
                            <option value="">-- Select Role --</option>
                            <option value="student" <?php echo e(old('role') === 'student' ? 'selected' : ''); ?>>
                                <i class="fas fa-graduation-cap"></i> Student
                            </option>
                            <option value="teacher" <?php echo e(old('role') === 'teacher' ? 'selected' : ''); ?>>
                                <i class="fas fa-chalkboard-user"></i> Teacher
                            </option>
                        </select>
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="••••••••"
                        >
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-check-circle mr-2 text-blue-600"></i>Confirm Password
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-blue-50 p-3 rounded-lg text-sm text-gray-700 border border-blue-200">
                        <p class="font-semibold mb-2">Password must contain:</p>
                        <ul class="space-y-1 text-xs">
                            <li><i class="fas fa-check text-green-600 mr-1"></i>At least 8 characters</li>
                            <li><i class="fas fa-check text-green-600 mr-1"></i>At least one uppercase letter</li>
                            <li><i class="fas fa-check text-green-600 mr-1"></i>At least one number</li>
                            <li><i class="fas fa-check text-green-600 mr-1"></i>At least one special character</li>
                        </ul>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start">
                        <input 
                            id="agree" 
                            type="checkbox" 
                            name="agree"
                            class="mt-1 rounded text-blue-600 focus:ring-blue-500 border-gray-300"
                            required
                        >
                        <label for="agree" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Privacy Policy</a>
                        </label><div id="password-match-error"
     class="hidden mt-2 p-2 bg-red-100 border border-red-300 text-red-700 rounded">
    ❌ Password and Confirm Password do not match.
</div>

<div id="password-match-success"
     class="hidden mt-2 p-2 bg-green-100 border border-green-300 text-green-700 rounded">
    ✅ Passwords match.
</div>
                    </div>



                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white font-bold py-3 rounded-lg hover:from-blue-700 hover:to-blue-900 transition transform hover:scale-105 flex items-center justify-center"
                    >
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <a 
                        href="<?php echo e(route('login')); ?>"
                        class="w-full block text-center bg-gray-100 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-200 transition flex items-center justify-center"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </form>
            </div>

            <!-- Footer Info -->
            <div class="bg-gray-50 px-8 py-4 border-t text-center text-sm text-gray-600">
                <p><i class="fas fa-shield-alt text-green-600 mr-1"></i>Your data is secure and encrypted</p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center text-white">
            <p class="text-sm">Need help? <a href="mailto:support@quizmaster.com" class="underline hover:text-blue-100 transition">Contact Support</a></p>
        </div>
    </div>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\online_quiz_system\resources\views/auth/register.blade.php ENDPATH**/ ?>