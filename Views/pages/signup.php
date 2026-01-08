<?php 

require_once __DIR__ . "/../partials/header.php";

?>
     
  


<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Create An Account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">




    
    <form action="/signup" method="POST" class="space-y-6 ">
          <div>
        <label for="email" class="block text-sm/6 font-medium text-black-100">Name</label>
        <div class="mt-2">
          <input id="email" placeholder = "enter your name" type="text" name="name" value="<?=htmlspecialchars($old['name'] ?? '')?>" required  class=" border-2 border-black-200 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-black-100 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>
           <?php if(!empty($errors['name'])): ?>

            <p class="text-red-700"><?=$errors['name'] ?? '' ?></p>
        
           <?php endif; ?>
      <div>
        <label for="email" class="block text-sm/6 font-medium text-black-100">Email address</label>
        <div class="mt-2">
          <input id="email" placeholder = "enter your email" type="email" name="email" value="<?=htmlspecialchars($old['email'] ?? '')?>" required autocomplete="email" class=" border-2 border-black-200 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-black-100 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>
        <?php if(!empty($errors['email'])): ?>

            <p class="text-red-700"><?=$errors['email'] ?? '' ?></p>
        
           <?php endif; ?>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-black-100">Password</label>
        </div>
        <div class="mt-2">
          <input id="password" placeholder = "enter your password"type="password" name="password"  required autocomplete="current-password" class="border-2 border-black-200 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>
          <?php if(!empty($errors['password'])): ?>

            <p class="text-red-700"><?=$errors['password'] ?? '' ?></p>
        
           <?php endif; ?>

      <select  name="role" class="border-2 border-blue-300 rounded-md " required>
       <option value="" disabled selected >choose role </option>
       <option value="reader">Reader</option>
       <option value="author">Author</option>
      </select>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create Account</button>
      </div>
    </form>
  </div>
</div>
<?php
require_once __DIR__ . "/../partials/footer.php"
?>