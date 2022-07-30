<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ACL\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    protected $permissions = [
        'خواندن حیوان'      => 'read-animal',
        'ویرایش حیوان'          => 'edit-animal',
        'ایجاد حیوان'        => 'create-animal',
        'حذف حیوان'          => 'delete-animal',
        'خواندن دسته بندی'        => 'read-category',
        'ویرایش دسته بندی'    => 'edit-category',
        'ایجاد دسته بندی'  => 'create-category',
        'حذف دسته بندی'    => 'delete-category',
        'خواندن مدیر'  => 'read-manager',
        'ویرایش مدیر'      => 'edit-manager',
        'ایجاد مدیر'    => 'create-manager',
        'حذف مدیر'      => 'delete-manager',
        'خواندن کاربر'    => 'read-user',
        'ویرایش کاربر'    => 'edit-user',
        'ایجاد کاربر'    => 'create-user',
        'حذف کاربر'    => 'delete-user',
        'خواندن نقش'    => 'read-role',
        'ویرایش نقش'    => 'edit-role',
        'ایجاد نقش'    => 'create-role',
        'حذف نقش'    => 'delete-role',
        'خواندن نظر'    => 'read-comment',
        'ویرایش نظر'    => 'edit-comment',
        'ایجاد نظر'    => 'create-comment',
        'حذف نظر'    => 'delete-comment',
        'خواندن تنظیمات'    => 'read-setting',
        'ویرایش تنظیمات'    => 'edit-setting',
        'خواندن سوالات'    => 'read-faq',
        'ویرایش سوالات'    => 'edit-faq',
        'ایجاد سوالات'    => 'create-faq',
        'حذف سوالات'    => 'delete-faq',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $key => $value) {
            Permission::create([
                'name' => $key,
                'slug' => $value
            ]);
        }
    }
}
