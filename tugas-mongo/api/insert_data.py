import json
from pymongo import MongoClient

client = MongoClient('mongodb://192.168.2.4:27017/?retryWrites=false&authSource=admin', username='mongo-admin', password='password')
db_news = client["news"]
news_collection = db_news["newsCollection"]

cnt = 1
with open('../dataset/News_Category_Dataset_v2.json') as fp:
    data = fp.readline()
    while data:
        data_json = json.loads(data)
        news_collection.insert_one(data_json)
        print('{}/200853 inserted'.format(cnt))
        cnt+=1

        data = fp.readline()


