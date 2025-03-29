<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
        
        <form wire:submit.prevent="login">
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    id="email"
                    type="email"
                    wire:model="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required
                    autofocus
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
            </div>

            <!-- Remember Me -->
            <div class="mb-4 flex items-center">
                <input
                    id="remember"
                    type="checkbox"
                    wire:model="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm"
                >
                <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700"
            >
                Login
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                Don't have an account? Register
            </a>
        </div>
    </div>
</div>
