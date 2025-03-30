#BUCKET=respaldoschile1.s3.us-east-2

aws s3 cp ./src/public s3://$BUCKET --recursive --acl public-read