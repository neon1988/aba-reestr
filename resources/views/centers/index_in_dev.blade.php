 @extends('layouts.app')

 @section('content')

     <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full text-center">
         <h1 class="text-2xl font-semibold text-gray-800 mb-6">
             Раздел в разработке
         </h1>
         <p class="text-lg text-gray-600 mb-6">
             Этот раздел находится в процессе разработки.
             Если вы хотите разместить информацию о вашем центре на нашей платформе, пожалуйста, свяжитесь с нами.
         </p>
         <div class="mt-6">
             <a href="{{ route('contacts') }}" class="text-lg bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                 Связаться с нами
             </a>
         </div>
     </div>

 @endsection


