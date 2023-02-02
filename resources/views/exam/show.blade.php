<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{Auth::user()->name}} - Sorteo de caso
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-center pt-8 pb-10 text-2xl font-extrabold text-secondary">
                        Titulo del evento
                    </div>
                    <div class="flex justify-center text-xl font-extrabold">
                        ¡Bienvenido {{Auth::user()->name}}!
                    </div>
                    <div class="flex justify-center text-center mt-5 text-sm font-bold">
                        "Alcanzar el éxito debe basarse no solo en el deseo de una conquista personal
                        <br> sino, también en la posibilidad de transformar la vida de otras personas.
                        <br> No existe un ascensor que te lleve al éxito, hay que tomar las escaleras."
                        <br><br>D. en D - Luis Jorge Gamboa Olea.

                    </div>
                    <div class="flex justify-center mt-8 text-xl font-bold">
                        Tu número es:
                    </div>
                    <div class="flex justify-center mt-8 text-xl font-bold">
                        1
                    </div>
                    <div class="flex justify-center mt-8 text-xl font-bold">
                        <a  href=""
                            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Descargar constancia</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
