<x-Play-layout>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">クイズ</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">{{ $quiz['question'] }}</p>
            </div>

            <form method="POST"
                action="{{ route('categories.quizzes.answer', [
                    'categoryId' => $categoryId,
                ]) }}">
                @csrf
                {{-- どのクイズの解答か認識するためにクイズIDを送る --}}
                <input type="hidden" name="quizId" value="{{ $quiz['id'] }}">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                            <tr>
                                <th
                                    class="w-10  whitespace-nowrap px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                    番号
                                </th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    選択肢
                                </th>
                                <th
                                    class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- 選択肢表示 --}}
                            @foreach ($quiz['options'] as $key => $option)
                                <tr>
                                    <td class="px-4 py-3">{{ $key + 1 }}</td>
                                    <td class="px-4 py-3">{{ $option['content'] }}
                                    </td>
                                    <td class="w-10 text-center">
                                        <input name="optionId[]" value="{{ $option['id'] }} "type="checkbox">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                    <button type="submit"
                        class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">解答
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-Play-layout>
