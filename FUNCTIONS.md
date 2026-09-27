# جدول الدوال الجاهزة والدوال السحرية المستخدمة في المشروع

## أولاً: دوال مكتبة PHP الجاهزة (Built-in Functions)

| الاسم | وين استعملتها | شو بتعمل | المصدر |
| :--- | :--- | :--- | :--- |
| `date` | في `Logger.php` لتوثيق وقت العملية، وفي `Product.php` لتحديد تاريخ إضافة المنتج | بترجع التاريخ والوقت الحاليين كنص منسق حسب الصيغة يللي بنعطيها ياها | https://www.php.net/manual/en/function.date.php |
| `file_put_contents` | في `Logger.php` لإضافة سطر السجل، وفي `JsonStorage.php` لحفظ الكتالوج في الملف | بتكتب نص جوات ملف على القرص مباشرة، وإذا الملف مو موجود بتنشؤو | https://www.php.net/manual/en/function.file-put-contents.php |
| `round` | في `PercentageDiscount.php` و`FixedDiscount.php` و`Product.php` و`PhysicalProduct.php` | بتقرّب الرقم العشري لعدد محدد من الخانات بعد الفاصلة مشان تضل الأسعار دقيقة | https://www.php.net/manual/en/function.round.php |
| `trim` | في `Product.php` و`DigitalProduct.php` و`JsonStorage.php` و`ProductCatalog.php` و`index.php` | بتحذف المسافات والفراغات الزايدة من أول وآخر النص | https://www.php.net/manual/en/function.trim.php |
| `strlen` | في `Product.php` داخل دالة `setName` | بتحسب كم حرف بطول النص مشان نتأكد إنو اسم المنتج مو أقصر من 3 أحرف | https://www.php.net/manual/en/function.strlen.php |
| `array_merge` | في `PhysicalProduct.php` و`DigitalProduct.php` داخل دالة `toArray` | بتدمج مصفوفتين أو أكثر بمصفوفة وحدة (جمعنا فيها بيانات المنتج المشتركة مع الخاصة) | https://www.php.net/manual/en/function.array-merge.php |
| `filter_var` | في `DigitalProduct.php` داخل دالة `setDownloadUrl` | بتفحص المتغير بفلتر معين لنتأكد إنو رابط التحميل للمنتج الرقمي رابط حقيقي وصالح | https://www.php.net/manual/en/function.filter-var.php |
| `file_exists` | في `JsonStorage.php` داخل دالة `loadAll` | بتفحص إذا الملف موجود أصلاً على الجهاز قبل ما نحاول نقرأ منو | https://www.php.net/manual/en/function.file-exists.php |
| `file_get_contents` | في `JsonStorage.php` داخل دالة `loadAll` | بتقرأ محتوى الملف كامل من القرص وبترجعو كنص واحد | https://www.php.net/manual/en/function.file-get-contents.php |
| `json_decode` | في `JsonStorage.php` داخل دالة `loadAll` | بتفك نص الـ JSON المخزن بالملف وبتحولو لمصفوفة ترابطية بـ PHP | https://www.php.net/manual/en/function.json-decode.php |
| `is_array` | في `JsonStorage.php` و`ProductCatalog.php` عند تحميل البيانات | بتتأكد إذا المتغير هو مصفوفة فعلية مشان نحمي البرنامج لو كان ملف الـ JSON مكسور | https://www.php.net/manual/en/function.is-array.php |
| `json_encode` | في `JsonStorage.php` داخل دالة `saveAll` | بتحول مصفوفة بيانات PHP لنص مرتب بصيغة JSON مشان نخزنو بالملف | https://www.php.net/manual/en/function.json-encode.php |
| `array_key_exists` | في `ProductCatalog.php` عند الإضافة والبحث والتعديل | بتفحص إذا مفتاح معين (مثل معرف المنتج ID) موجود مسبقاً جوات المصفوفة | https://www.php.net/manual/en/function.array-key-exists.php |
| `count` | في `ProductCatalog.php` داخل دالة `getProductsCount` | بتعد كم عنصر موجود حالياً جوات مصفوفة المنتجات | https://www.php.net/manual/en/function.count.php |
| `strtolower` | في `ProductCatalog.php` و`index.php` لتوحيد حالة الأحرف | بتحول كل أحرف النص لأحرف صغيرة (small letters) لتسهيل مقارنتها | https://www.php.net/manual/en/function.strtolower.php |
| `fgets` | في `index.php` داخل دالة `readInput` | بتقرأ سطر كامل بيكتبو المستخدم بالـ Terminal | https://www.php.net/manual/en/function.fgets.php |
| `is_numeric` | في `index.php` داخل دوال قراءة الأرقام `readFloatInput` و`readIntInput` | بتفحص إذا النص يللي دخلو المستخدم هو رقم صالح قبل ما نحولو لحسابات | https://www.php.net/manual/en/function.is-numeric.php |