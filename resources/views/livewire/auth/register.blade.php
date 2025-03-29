<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Register</h1>
        
        <form wire:submit.prevent="register">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input
                    id="name"
                    type="text"
                    wire:model="name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                    autofocus
                >
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    id="email"
                    type="email"
                    wire:model="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                >
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    id="password"
                    type="password"
                    wire:model="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                >
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    wire:model="password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                >
            </div>

            <!-- Terms -->
            <div class="mb-4 flex items-center">
                <input
                    id="terms"
                    type="checkbox"
                    wire:model="terms"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm"
                    required
                >
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-800">Terms of Service</a>
                </label>
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700"
            >
                Register
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                Already registered? Login
            </a>
        </div>
    </div>
</div>