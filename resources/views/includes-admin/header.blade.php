 <div class="bg-dark text-white px-4 py-3 mb-0 d-flex justify-content-between align-items-center shadow">

     <a href="{{ url('/') }}" class="text-white text-decoration-none fw-bold">
         🏠 На сайт
     </a>

     <h4 class="m-0">
         🔐 @section('title')
     </h4>

     <form method="POST" action="{{ route('logout') }}">
         @csrf
         <button class="btn btn-outline-light btn-sm">
             🚪 Выйти
         </button>
     </form>

 </div>
