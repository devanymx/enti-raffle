<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de administración
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-96">
                <div class="p-6 sm:px-20 bg-white shadow border-b border-gray-200">
                    <div class="mx-auto w-1/2 mb-10 mt-10">
                        <form action="{{route('user.confirm')}}" method="post">
                            @csrf
                            <label for="code" class="block text-sm font-medium text-gray-700">Número de registro</label>
                            <div class="mt-4 mb-4">
                                <input type="text" name="code" id="code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="000">
                            </div>
                            <div class="mt-10 w-100 text-center">
                                <input type="submit" class="mx-auto inline-flex items-center rounded-md border border-transparent bg-principal px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" value="Enviar" />
                            </div>
                            <div class="flex justify-center pt-8 pb-10 text-xl font-extrabold text-secondary">
                                @if($message)
                                    {{$message}}
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
