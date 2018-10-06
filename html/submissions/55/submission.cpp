
#include <bits/stdc++.h>
using namespace std;
typedef vector<int> VI;
typedef pair<int,int> II;
typedef long long LL;
#define FOR(i,a,b) for(int i=(a),_b=(b); i<=_b ;i++)
#define DOW(i,b,a) for(int i=(b),_a=(a); i>=_a ;i--)
#define TR(c,i) for(decltype((c).begin()) i = (c).begin(); i != (c).end(); i++)
#define SZ(a) int((a).size())
#define ALL(a) (a).begin(),(a).end()
#define PRESENT(c,x) ((c).find(x)!=(c).end())
#define VPRESENT(c,x) (find(all(c),x)!=(c).end())
#define MP make_pair
#define PB push_back
#define FI first
#define SE second

#define md int(1e5+100)
#define mc int(1e5+100)
#define inf int(1e9+100)
#define modul int(1e9+7)

template <typename T1, typename T2> auto Min(T1 a, T2 b) { return (a<b)?a:b; }
template <typename T1, typename T2> auto Max(T1 a, T2 b) { return (a>b)?a:b; }

struct point
{
    int x,y,i;
};

int n;

int main()
{
    //freopen("inp.txt","r",stdin);
    //freopen("out.txt","w",stdout);
    char s[100];
    scanf("%s",s);
    n=strlen(s);
    int res=0;
    FOR(i,0,n-1)
    {
        int x=s[i]-'0';
        if (x%2==1) res+=x;
    }
    cout<<res<<endl;
}

