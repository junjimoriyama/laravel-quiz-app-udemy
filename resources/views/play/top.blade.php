<x-Play-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap w-full mb-20">
                <div class="w-full mb-6 lg:mb-0">
                    <h1 class="text-center sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">カテゴリーを選択してください</h1>
                    <div class="mx-auto h-1 w-20 bg-indigo-500 rounded"></div>
                </div>
                <p class="lg:w-1/2 w-full leading-relaxed text-gray-500">
                </p>
            </div>

            <div class="flex flex-wrap justify-center -m-4">
            @foreach ($categories as $category)
                <div class="xl:w-1/4 md:w-1/2 p-4 ">
                    <a href="{{ route('categories', ['categoryId' => $category->id ]) }}" class="bg-slate-200 p-6 rounded-lg block">
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-4"> {{ $category->name }}</h2>
                        <p class="leading-relaxed text-base">
                            {{$category->description}}
                        </p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-Play-layout>
