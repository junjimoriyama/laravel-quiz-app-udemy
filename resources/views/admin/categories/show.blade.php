<x-admin-layout>
    <section class="text-gray-600 body-font relative mt-5">
        <div class="container px-5 py-6 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $category->name }}</h1>
                <p>{{ $category->description }}</p>
            </div>

            {{-- カテゴリー編集ボタン --}}
            <div class="sm:w-1/2 ml-auto">
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 w-full">
                        <button onclick="location.href='{{ route('admin.categories.create') }}'"
                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">カテゴリー編集
                        </button>
                    </div>
                </div>
            </div>

            {{-- クイズ新規登録ボタン --}}
            <div class="sm:w-1/2 ml-auto mt-2">
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 w-full">
                        <button onclick="location.href='{{ route('admin.categories.create') }}'"
                            class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">カテゴリー新規登録
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- クイズ新規登録ボタン --}}
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-5 mx-auto">
            <div class="lg:w-3/4 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                        <tr>
                            @foreach (['ID', 'クイズ問題文', '更新日時', '詳細', '削除'] as $heading)
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-300">
                                    {{ $heading }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($categories as $category) --}}
                        <tr>
                            <td class="px-4 py-3">{{ $category->name }}</td>
                            <td class="px-4 py-3">{{ $category->description }}</td>
                            <td class="px-4 py-3">{{ $category->updated_at }}</td>
                            <td class="px-4 py-3 text-lg text-gray-900">
                                <button
                                    {{-- onclick="location.href='{{ route('admin.categories.show', ['categoryId' => $category->id]) }}'" --}}
                                    {{-- カテゴリー編集ページに遷移 --}}
                                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">編集
                                </button>
                            </td>
                            <td class="px-4 py-3 text-lg text-gray-900">
                                <button
                                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">削除
                                </button>
                            </td>
                        </tr>
                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-admin-layout>
