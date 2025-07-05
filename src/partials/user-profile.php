 <section class="bg-gray-50 p-6  dark:bg-gray-900 flex justify-center items-center">
            <form class="space-y-4 md:space-y-6" action="" method="post" enctype="multipart/form-data">
                <div class="flex flex-col bg-white  max-w-screen-xl items-center justify-center px-6 py-8 rounded-lg shadow dark:border xl:p-0 dark:bg-gray-800 dark:border-gray-700 w-4xl">
                    <div>
                        <h1 class="pl-8 pt-6 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl dark:text-white">
                            Hello ! <span class="text-primary-700"><?= $formData['name'] ?? 'User' ?></span>
                        </h1>
                        <div class="flex">
                            <div class="">
                                <div class="w-lg p-6 space-y-4 md:space-y-6 sm:p-8">
                                    <div>
                                        <input type="hidden" name="id" value="<?= $formData['id'] ?? '' ?>">
                                        <label for="title"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                        <input type="text" name="name" id="name" value="<?= $formData['name'] ?? '' ?>"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="" >
                                    </div>
                                    <div>
                                        <label for="title"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" name="email" id="email" value="<?= $formData['email'] ?? '' ?>"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="" >
                                    </div>
                                    <div>
                                        <label for="title"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old
                                            Password</label>
                                        <input type="password" name="old_password" id="old_password"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="••••••••" >
                                    </div>
                                    <div>
                                        <label for="title"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                                            Password</label>
                                        <input type="text" name="new_password" id="new_password"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="••••••••" >
                                    </div>

                                </div>

                            </div>
                            <div class="flex flex-col items-center justify-start space-y-10 sm:p-8">
                                <div>
                                <img class="h-40 rounded-lg" src="<?php
                                $img = $formData['image'] != '' ? $formData['image']: 'assets/images/user.webp' ;
                                echo BASE_URL .$img ?>"
                                     alt="image description">
                                </div>
                                <div class="h-10 flex flex-col">
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Profile Image</label>
                                    <label for="dropzone-file"
                                           class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center p-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                        class="font-semibold">Click to upload</span> or drag and
                                                drop
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF
                                                (MAX.
                                                2MB)</p>
                                        </div>
                                        <input id="dropzone-file" type="file"
                                               accept="image/png, image/jpg, image/jpeg, image/gif, image/webp"
                                               name="user_image" class="hidden"/>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-fit mb-5">
                        <input type="submit" name="action" value="Save"
                               class=" col-span-2 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    </div>
                </div>
            </form>
        </section>
