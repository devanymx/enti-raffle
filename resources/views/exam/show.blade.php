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
                        Tu número de expediente es:
                    </div>
                    <div class="flex justify-center pt-8 pb-0 text-2xl font-extrabold text-secondary">
                        <span id="winner-name"></span>
                        <span id="winner-code"></span>
                    </div>
                    <div class="flex justify-center pt-0 pb-10 text-2xl font-extrabold text-secondary">
                        <span id="winner-text"></span>
                    </div>
                    <div class="flex justify-center mt-8 text-xl font-bold">
                        <a  href="{{route('exam.download', ['uuid'=>'c025432e-e590-4afd-a808-d6d143ebe55f'])}}" id="download"
                            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Descargar constancia</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", async function () {
        document.getElementById("download").style.display="none";
        for (let ran = 0; ran < 4; ran++) {
            document.getElementById("winner-name").textContent=".";
            document.getElementById("winner-text").textContent="Cargando Tombola";
            await new Promise(r => setTimeout(r, 500));
            document.getElementById("winner-name").textContent="..";
            document.getElementById("winner-text").textContent="Cargando Tombola";
            await new Promise(r => setTimeout(r, 500));
            document.getElementById("winner-name").textContent="...";
            document.getElementById("winner-text").textContent="Cargando Tombola";
            await new Promise(r => setTimeout(r, 500));
        }
        document.getElementById("winner-text").textContent="";
        for (let ran = 0; ran < 30; ran++) {
            let code = randomCode(6);
            let name = randomName(16);
            document.getElementById("winner-name").textContent=name;
            document.getElementById("winner-code").textContent=code;

            await new Promise(r => setTimeout(r, 100));
        }
        await new Promise(r => setTimeout(r, 500));
        document.getElementById("winner-name").textContent="";
        document.getElementById("winner-code").textContent="{{$code}}";
        document.getElementById("download").style.display="block";
    });
    function randomName(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            if (i === 5 || i === 10){
                result += ' ';
            }else{
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
        }
        return result;
    }
    function randomCode(length) {
        var result           = '';
        var characters       = '*+-/';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() *
                charactersLength));
        }
        return result;
    }
</script>
