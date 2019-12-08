from flask import Flask
import mysql.connector
import json
from flask import jsonify, request

app = Flask(__name__)
app.secret_key = "BEDETE"
db = mysql.connector.connect(
  host="192.168.16.33",
  user="root",
  passwd="",
  database="news",
  port=4000
)


@app.route('/news', methods=['GET'])
def get_news():
    cur = db.cursor()
    cur.execute("SELECT * FROM data")

    data = []
    for (news_id, category, headline, authors, link, short_description, date) in cur:
        temp = {}
        temp["id"] = news_id
        temp["category"] = category;
        temp["headline"] = headline;
        temp["authors"] = authors;
        temp["link"] = link;
        temp["short_description"] = short_description;
        temp["date"] = date.strftime("%Y-%m-%d");
        data.append(temp)

    db.commit()
    cur.close()
    resp = json.dumps(data)
    return resp

@app.route('/news/<news_id>', methods=['GET'])
def get_one_news(news_id):
    cur = db.cursor()
    cur.execute("SELECT * FROM data WHERE id={}".format(news_id))

    data = []
    for (news_id, category, headline, authors, link, short_description, date) in cur:
        temp = {}
        temp["id"] = news_id
        temp["category"] = category;
        temp["headline"] = headline;
        temp["authors"] = authors;
        temp["link"] = link;
        temp["short_description"] = short_description;
        temp["date"] = date.strftime("%Y-%m-%d");
        data.append(temp)

    db.commit()
    cur.close()
    resp = json.dumps(data[0])
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

    
    cur = db.cursor()
    cur.execute("INSERT INTO data (`category`, `headline`, `authors`, `link`, `short_description`, `date`) VALUES (%s, %s, %s, %s, %s, %s)", (news_category, news_headline, news_authors, news_link, news_short_description, news_date));
    news_id = cur.lastrowid
    db.commit()
    cur.close()

    resp = jsonify('News with id = {} added successfully!'.format(news_id))
    resp.status_code = 200
    return resp

@app.route('/news/<news_id>',methods=['PUT'])
def update_news(news_id):
    request_json = request.json
    news_category = request_json["category"]
    news_headline = request_json["headline"]
    news_authors = request_json["authors"]
    news_link = request_json["link"]
    news_short_description = request_json["short_description"]
    news_date = request_json["date"]

    cur = db.cursor()
    cur.execute("UPDATE data SET date = %s, category = %s, headline = %s, authors = %s, link = %s, short_description = %s WHERE id=%s", (news_date, news_category, news_headline, news_authors, news_link, news_short_description, news_id));
    db.commit()
    cur.close()

    resp = jsonify('News updated successfully!')
    resp.status_code = 200
    return resp

@app.route('/news/<news_id>', methods=['DELETE'])
def delete_news(news_id):
    request_json = request.json
    news_category = request_json["category"]
    news_headline = request_json["headline"]
    news_authors = request_json["authors"]
    news_link = request_json["link"]
    news_short_description = request_json["short_description"]
    news_date = request_json["date"]

    cur = db.cursor()
    cur.execute("DELETE FROM data WHERE id={}".format(news_id));
    db.commit()
    cur.close()

    resp = jsonify('News deleted successfully!')
    resp.status_code = 200
    return resp

if __name__ == "__main__":
    app.run()