<div class="p-3">
    <div class="bg-white p-6 space-y-5">
        <p><?php echo __( 'Analyze words, unique words and phrases in your Articles, Pages and comments.', 'wcadomain' ); ?></p>
        <label for="countries"
               class="block mb-2 text-sm font-medium text-gray-900"><?php echo __( 'What language is your website in?', 'wcadomain' ) ?></label>
        <select id="countries"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            <option value="en">English</option>
            <option value="de">German</option>
            <option value="fr">French</option>
            <option value="hi">Hindi</option>
            <option value="id">Indonesian</option>
            <option value="it">Italian</option>
            <option value="ja">Japanese</option>
            <option value="lv">Latvian</option>
            <option value="nl">Dutch; Flemish</option>
            <option value="es">Spanish; Castilian</option>
            <option value="bg">Bulgarian</option>
            <option value="cs">Czech</option>
            <option value="pl">Polish</option>
            <option value="pt">Portuguese</option>
            <option value="ru">Russian</option>
            <option value="sv">Swedish</option>
            <option value="zh">Chinese</option>
            <option value="el">Greek, Modern (1453-)</option>

        </select>
        <button type="button" id="calc"
                class="text-white bg-green-600 hover:bg-green-500 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center inline-flex items-center mr-2">
            <svg id="logo_svg" class="mr-2 -ml-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                 preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                <path fill="currentColor"
                      d="M15 4h-5V3h5v1zm-1 3h-2v1h2V7zm-4 0H1v1h9V7zm2 6H1v1h11v-1zm-5-3H1v1h6v-1zm8 0h-5v1h5v-1zM8 2v3H1V2h7zM7 3H2v1h5V3z"></path>
            </svg>
            <svg id="loading" class="inline mr-3 w-4 h-4 text-white animate-spin hidden" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
            </svg>
			<?php echo __( 'Count and analyze words', 'wcadomain' ) ?>
        </button>
    </div>
</div>