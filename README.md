Script to verify and download images that not found in the file directory. Steps to verify:

1- Export the csv products from the backend and save inside csv folder with the name products.csv

2- To get the all images from products execute, this create the file images.csv: 

```

> php CsvImages.php

```

3- With the previous csv we can obtain the not found iamges of each products and save into imagesNotFound.csv, with the command:

```

> php VerifyImages.php

```

4- To download all the images only execute:

```

> php DownloadImages.php

```

All the images are saved in __image__ folder
