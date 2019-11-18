from flask import Flask
from flask_pymongo import PyMongo
from flask import jsonify, request
from bson.json_util import dumps
from bson.objectid import ObjectId

app = Flask(__name__)
app.secret_key = "BEDETE"
app.config["MONGO_URI"] = "mongodb://mongo-admin:password@192.168.2.4:27017/news?retryWrites=false&authSource=admin"
mongo = PyMongo(app)

@app.route('/news', methods=['GET'])
def get_news():
    news = mongo.db.newsCollection.find()
    resp = dumps(news)
    return resp

@app.route('/news', methods=['POST'])
def add_news():
    request_json = request.json
    news_category = request_json["category"]
    news_headline = request_json["headline"]
    news_authors = request_json["authors"]
    news_link = request_json["link"]
    news_short_description = request_json["short_description"]
    news_date = request_json["date"]

    news_id = mongo.db.newsCollection.insert({
        'category':news_category,
        'headline':news_headline,
        'authors':news_headline,
        'link':news_link,
        'short_description':news_short_description,
        'date':news_date,
    })

    resp = jsonify('News added successfully! with id = {}'.format(news_id))
    resp.status_code = 200
    return resp

@app.route('/news/<id>',methods=['PUT'])
def update_news(id):
    request_json = request.json
    news_id = request_json["_id"]
    news_category = request_json["category"]
    news_headline = request_json["headline"]
    news_authors = request_json["authors"]
    news_link = request_json["link"]
    news_short_description = request_json["short_description"]
    news_date = request_json["date"]

    mongo.db.newsCollection.update_one(
        {'_id': ObjectId(news_id['$oid']) if '$oid' in news_id else ObjectId(news_id)},
        {
            '$set': {
                'category':news_category,
                'headline':news_headline,
                'authors':news_headline,
                'link':news_link,
                'short_description':news_short_description,
                'date':news_date,
            }
        }
    )

    resp = jsonify('News updated successfully! with id = {}'.format(news_id))
    resp.status_code = 200
    return resp

@app.route('/news/<id>', methods=['DELETE'])
def delete_news(id):
	mongo.db.newsCollection.delete_one({'_id': ObjectId(id)})
	resp = jsonify('News deleted successfully! with id = {}'.format(id))
	resp.status_code = 200
	return resp

@app.route('/news/facet', methods=['GET'])
def facet_news():
    facet_news = mongo.db.newsCollection.aggregate([
        {
            "$group": {
                "_id":"$category",
                "count":{"$sum":1}
            }
        }
    ])
    resp = dumps(facet_news)
    return resp

@app.route('/news/facet_date', methods=['GET'])
def facet_date():
    facet_date = mongo.db.newsCollection.aggregate([
        {
            "$group": {
                "_id":"$date",
                "count":{"$sum":1}
            }
        }
    ])
    resp = dumps(facet_date)
    return resp

@app.route('/news/sum', methods=['GET'])
def news_sum():
    news_sum = mongo.db.newsCollection.aggregate([
        {
            "$group": {
                "_id":"_id",
                "count":{"$sum":1}
            }
        }
    ])
    resp = dumps(news_sum)
    return resp


if __name__ == "__main__":
    app.run()